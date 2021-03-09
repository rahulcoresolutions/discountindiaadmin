<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('category/sort' , ['as' => 'category.sort' , 'uses' => 'UsersController@sortCategory']);

Route::get('report/generate/merchants' , ['as' => 'report.generate.merchants' , 'uses' => 'ReportController@getMerchantReports']);
Route::get('voucher/report' , ['as' => 'voucher.report' , 'uses' => 'ReportController@voucherReport']);

Route::get('change/voucher/deactivate/{id}' , ['as' => 'change.voucher.deactivate' , 'uses' => 'Admin\VouchersController@deactivateVoucher']);
Route::get('change/voucher/activate/{id}' , ['as' => 'change.voucher.activate' , 'uses' => 'Admin\VouchersController@activateVoucher']);

Route::get('change/merchant/deactivate/{id}' , ['as' => 'change.merchant.deactivate' , 'uses' => 'Admin\OffersController@deactivateMerchant']);
Route::get('change/merchant/activate/{id}' , ['as' => 'change.merchant.activate' , 'uses' => 'Admin\OffersController@activateMerchant']);

Route::get('list/merchants/{offerId}' , [ 'as' => 'list.vouchers.merchant' , 'uses' => 'UsersController@listMerchants' ]);
Route::post('sort/merchant/voucher' , ['as' => 'sort.merchant.voucher' , 'uses' => 'UsersController@sortMerchantVocuher']);
Route::get('sub/category/hot/deals' , ['as' => 'hot.deals.category' , 'uses' => 'Admin\HotDealsController@getSubCategoryDeals']);
Route::post('store/hotdeals/category' , ['as' => 'hotdeals.store' , 'uses' => 'Admin\HotDealsController@hotDealCategoryStore']);
Route::get('add/hot/deals/category/{id}' , ['as' => 'add.hot.deals.category' , 'uses' => 'Admin\HotDealsController@hotDealsVouchers']);
Route::post('category/hot/deals/store' , ['as' => 'category.hot.deals.store' , 'uses' => 'Admin\HotDealsController@SaveHotDeals']);