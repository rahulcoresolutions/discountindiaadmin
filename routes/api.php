<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::POST('register/user' ,				['as' => 'register.user' , 'uses' => 'ApiController@registerUser'] );
Route::POST('login/user' ,					['as' => 'login.user' , 'uses' => 'ApiController@loginUser'] );
Route::GET('get/categories' ,				['as' => 'get.categories' , 'uses' => 'ApiController@Categories'] );
Route::GET('get/cities' ,					['as' => 'get.cities' , 'uses' => 'ApiController@getCities'] );
Route::GET('get/offers' ,					['as' => 'get.offers' , 'uses' => 'ApiController@getOffers'] );
Route::GET('list/plans' ,					['as' => 'get.plans' , 'uses' => 'ApiController@getPlans'] );
Route::GET('get/user/profile/{id}' ,		['as' => 'get.user.profile' , 'uses' => 'ApiController@getUserProfile'] );
Route::GET('get/vouchers/{id}/{plan_id}/{user_id}' ,	['as' => 'get.offers.vouchers' , 'uses' => 'ApiController@getVouchers'] );
Route::GET('get/hot/deals/{user_id}/{cityId}' ,		['as' => 'get.hot.deals' , 'uses' => 'ApiController@getHotDeals'] );
Route::GET('get/premium/deals/{cityId}' ,	['as' => 'get.premium.deals' , 'uses' => 'ApiController@getPremiumDeals'] );
Route::GET('get/share/voucher/deals/{userId}' ,	['as' => 'get.shareed.vouchers.deals' , 'uses' => 'ApiController@getSharedVouchers'] );
Route::GET('get/voucher/{id}' ,				['as' => 'get.unique.voucher' , 'uses' => 'ApiController@getUniqueVoucher'] );
Route::GET('get/user/redeem/voucher/{id}' ,	['as' => 'get.user.redeem.voucher' , 'uses' => 'ApiController@getUserRedeemedVoucher'] );


Route::GET('get/paid/voucher/details/{id}' , 	['as' => 'paid.voucher.details' 	, 'uses' => 'ApiController@getPaidVoucherDetails']);
Route::GET('list/paid/voucher/{id}' , 			['as' => 'list.paid.voucher' 		, 'uses' => 'ApiController@getPaidVoucherList']);


Route::GET('list/shared/paid/voucher/{id}' , 	['as' => 'list.shared.paid.voucher' , 'uses' => 'ApiController@getSharedPaidVoucherList']);
Route::GET('get/share/voucher/details/{id}' , 	['as' => 'share.voucher.details' 	, 'uses' => 'ApiController@getShareVoucherDetails']);
Route::GET('get/voucherUniqueId/{id}/{merchantId}' , 		['as' => 'get.voucher.unique' 		, 'uses' => 'ApiController@voucherUniqueId']);
Route::GET('admin/redeem/voucher/{voucherId}/{customerId}/{userId}' , ['as' => 'redeem.voucher' , 'uses' => 'ApiController@redeemVoucher']);
Route::GET('redeem/voucher/paid/{paidVoucherId}/{merchantId}' , ['as' => 'redeem.voucher.paid' , 'uses' => 'ApiController@redeemPaidVoucher']);
Route::GET('admin/get/client/voucher/{userId}' ,['as' => 'get.client.voucher' 		, 'uses' => 'ApiController@getClientVoucher']);
Route::POST('create/admin/voucher' , 			['as' => 'create.admin.voucher' 	, 'uses' => 'ApiController@createPaidVoucherByadminApp' ]);
Route::POST('admin/check/user/exist' , 			['as' => 'check.user.exist' 		, 'uses' => 'ApiController@checkUserExist']);
Route::POST('admin/check/otp/verify' , 			['as' => 'check.otp.verify' 		, 'uses' => 'ApiController@checkOtpVerify']);
Route::POST('admin/update/password' , 			['as' => 'admin.update.password' 	, 'uses' => 'ApiController@updatePassword']);
Route::POST('update/voucher/payment/status',	['as' => 'update.voucher.payment.status' , 'uses' => 'ApiController@updatePaymentStatus']);
Route::post('update/token' , 					['as' => 'update.token' 			, 'uses' => 'ApiController@updateToken']);
Route::post('save/user' , 					    ['as' => 'save.user' 			    , 'uses' => 'ApiController@saveUser']);



Route::get('get/delivery/{city}' ,              ['as' => 'get.delivery'             , 'uses' => 'ApiController@getDelivery']);
Route::get('get/sub/category' ,                 ['as' => 'get.sub.category'         , 'uses' => 'ApiController@getsubCategory' ]);
Route::get('get/deals/sub/category/{id}' ,      ['as' => 'get.sub.category.by.deal' , 'uses' => 'ApiController@getSubCategoryDetailsById' ]);
Route::get('get/slider' ,                       ['as' => 'get.slider'               , 'uses' => 'ApiController@gettopslider' ]);

Route::get('get/deals/category/{city}' ,    ['as' => 'get.hot.deals.category'   , 'uses' => 'ApiController@getHotDealsCategory']);