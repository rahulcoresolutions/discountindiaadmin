<?php
use Illuminate\Support\Facades\View;
use CoreSolutions\CoreAdmin\Models\Menu;

if (config('coreadmin.standaloneRoutes')) {
    return;
}

if (Schema::hasTable('menus')) {
    $menus = Menu::with('children')->where('menu_type', '!=', 0)->orderBy('position')->get();
    View::share('menus', $menus);
    if (! empty($menus)) {
        Route::group([
            'middleware' => ['web', 'auth', 'role'],
            'prefix'     => config('coreadmin.route'),
            'as'         => config('coreadmin.route') . '.',
            'namespace'  => 'App\Http\Controllers',
        ], function () use ($menus) {
            foreach ($menus as $menu) {
                switch ($menu->menu_type) {
                    case 1:
                        Route::post(strtolower($menu->name) . '/massDelete', [
                            'as'   => strtolower($menu->name) . '.massDelete',
                            'uses' => 'Admin\\' . ucfirst(camel_case($menu->name)) . 'Controller@massDelete'
                        ]);
                        Route::resource(strtolower($menu->name),
                            'Admin\\' . ucfirst(camel_case($menu->name)) . 'Controller', ['except' => 'show']);
                        break;
                    case 3:
                        Route::get(strtolower($menu->name), [
                            'as'   => strtolower($menu->name) . '.index',
                            'uses' => 'Admin\\' . ucfirst(camel_case($menu->name)) . 'Controller@index',
                        ]);
                        break;
                }
            }
        });
    }
}

Route::group([
    'namespace'  => 'CoreSolutions\CoreAdmin\Controllers',
    'middleware' => ['web', 'auth']
], function () {
    // Dashboard home page route
   // Route::get(config('coreadmin.homeRoute'), config('coreadmin.homeAction','CoreAdminController@index'));
    Route::group([
        'middleware' => 'role'
    ], function () {
        // Menu routing
        Route::get(config('coreadmin.route') . '/menu', [
            'as'   => 'menu',
            'uses' => 'CoreAdminMenuController@index'
        ]);
        Route::post(config('coreadmin.route') . '/menu', [
            'as'   => 'menu',
            'uses' => 'CoreAdminMenuController@rearrange'
        ]);

        Route::get(config('coreadmin.route') . '/menu/edit/{id}', [
            'as'   => 'menu.edit',
            'uses' => 'CoreAdminMenuController@edit'
        ]);
        Route::post(config('coreadmin.route') . '/menu/edit/{id}', [
            'as'   => 'menu.edit',
            'uses' => 'CoreAdminMenuController@update'
        ]);

        Route::get(config('coreadmin.route') . '/menu/crud', [
            'as'   => 'menu.crud',
            'uses' => 'CoreAdminMenuController@createCrud'
        ]);
        Route::post(config('coreadmin.route') . '/menu/crud', [
            'as'   => 'menu.crud.insert',
            'uses' => 'CoreAdminMenuController@insertCrud'
        ]);

        Route::get(config('coreadmin.route') . '/menu/parent', [
            'as'   => 'menu.parent',
            'uses' => 'CoreAdminMenuController@createParent'
        ]);
        Route::post(config('coreadmin.route') . '/menu/parent', [
            'as'   => 'menu.parent.insert',
            'uses' => 'CoreAdminMenuController@insertParent'
        ]);

        Route::get(config('coreadmin.route') . '/menu/custom', [
            'as'   => 'menu.custom',
            'uses' => 'CoreAdminMenuController@createCustom'
        ]);
        Route::post(config('coreadmin.route') . '/menu/custom', [
            'as'   => 'menu.custom.insert',
            'uses' => 'CoreAdminMenuController@insertCustom'
        ]);

        Route::get(config('coreadmin.route') . '/actions', [
            'as'   => 'actions',
            'uses' => 'UserActionsController@index'
        ]);
        Route::get(config('coreadmin.route') . '/actions/ajax', [
            'as'   => 'actions.ajax',
            'uses' => 'UserActionsController@table'
        ]);
    });
});

Route::group([
    'namespace'  => 'App\Http\Controllers',
    'middleware' => ['web']
], function () {
    // Point to App\Http\Controllers\UsersController as a resource
    Route::group([
        'middleware' => 'role'
    ], function () {
        Route::resource('users', 'UsersController');
        Route::resource('roles', 'RolesController');
    });
    Route::get('admin/add/voucher/{id}', [
        'as'   => 'add.voucher',
        'uses' => 'Admin\VouchersController@create'
    ]);
    Route::get('admin/change/status/{id}', [
        'as'   => 'change.status',
        'uses' => 'UsersController@activeUser'
    ]);
    Route::get('admin/deactivate/status/{id}', [
        'as'   => 'deacativate.status',
        'uses' => 'UsersController@deactivateUser'
    ]);
    Route::post('admin/create/voucher', [
        'as'   => 'craete.voucher',
        'uses' => 'Admin\VouchersController@store'
    ]);
    Route::post('admin/create/voucher/redeem', [
        'as'   => 'craete.voucher.redeem',
        'uses' => 'Admin\RedeemVoucherController@store'
    ]);
    Route::get('get/user/plan/{id}', [
        'as'   => 'get.user.plan',
        'uses' => 'UsersController@getUserPlan'
    ]);

    Route::get('get/voucher/details', [
        'as'   => 'get.voucher.details',
        'uses' => 'Admin\RedeemVoucherController@getVoucherDetails'
    ]);
    Route::get('login/user', [
        'as'   => 'login.user',
        'uses' => 'UsersController@loginUser'
    ]);
    Route::get('user/renewals', [
        'as'   => 'upcomming.renewals',
        'uses' => 'UsersController@upcommingRenewals'
    ]);
    
    Route::get('voucher/clone/{voucherId}' ,        ['as' => 'voucher.clone' , 'uses' => 'Admin\RedeemVoucherController@cloneVoucher']);
    Route::get('dashboard' ,                        ['as' => 'dashboard' , 'uses' => 'UsersController@dashboard']);
    Route::post('order/sort' ,                      ['as' => 'order.sort' , 'uses' => 'Admin\OffersController@orderSort']);
    Route::post('hot/product/sort' ,                ['as' => 'hot.product.sort' , 'uses' => 'Admin\HotDealsController@sortHotItems']);

    Route::get('get/order/logs' ,                   ['as' => 'get.order.logs' , 'uses' => 'Admin\OffersController@offersLog']);
    Route::get('get/user/voucher/{id}',             ['as' => 'get.user.voucher' , 'uses' => 'Admin\OffersController@getusedVoucher']);
    Route::post('get/voucher/filter/details',       ['as' => 'get.voucher.details.filter' , 'uses' => 'Admin\OffersController@getVoucherFilterDetails']);

    Route::get('get/paid/vouchers' ,                ['as' => 'get.paid.voucher' , 'uses' => 'Admin\PaidVoucherController@index']);
    Route::get('create/paid/vouchers' ,             ['as' => 'create.paid.voucher' , 'uses' => 'Admin\PaidVoucherController@createPaidVoucher']);
    Route::get('list/shared/voucher' ,              ['as' => 'list.share.voucher' , 'uses' => 'Admin\PaidVoucherController@listShareVoucher']);

    Route::get('list/notification' ,                ['as' => 'list.notification' , 'uses' => 'UsersController@listNotification']);
    Route::get('create/notification' ,              ['as' => 'create.notification' , 'uses' => 'UsersController@createNotification']);
    Route::post('store/notifications' ,             ['as' => 'store.notification' , 'uses' => 'UsersController@storeNotifications']);
    Route::get('notification/update/status/{id}' ,  ['as' => 'notification.update.status' , 'uses' => 'UsersController@notificationUpdateStatus']);

    Route::post('voucher/share' , ['as' => 'share.voucher' , 'uses' => 'Admin\PaidVoucherController@shareVoucher']);
    Route::post('create/paid/voucher' , ['as' => 'craete.paid.voucher' , 'uses' => 'Admin\PaidVoucherController@store']);
    Route::auth();
    Route::post('get/category/offers' , ['as' => 'get.cat.offers' , 'uses' => 'Admin\PaidVoucherController@getCatOffers']);

    Route::GET('delete/paid/voucher/{id}' ,         ['as' => 'delete.paid.voucher'      , 'uses' => 'Admin\PaidVoucherController@deletePaidVoucher']);
    Route::GET('edit/paid/voucher/{id}' ,           ['as' => 'edit.paid.voucher'        , 'uses' => 'Admin\PaidVoucherController@getPaidVoucherDetails']);
    Route::post('update/paid/voucher' ,             ['as' => 'update.paid.voucher'        , 'uses' => 'Admin\PaidVoucherController@updatetPaidVoucherDetails']);

});