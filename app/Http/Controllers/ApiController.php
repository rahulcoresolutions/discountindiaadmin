<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Categories;
use App\Cities;
use App\Offers;
use App\Topslider;
use Hash;
use App\PlanVoucherMap;
use App\Vouchers;
use App\PaidVouchers;
use App\HotDeals;
use App\Subcategory;
use Mail;
use App\SubscribePlan;
use App\ShareVoucher;
use App\RedeemPaidVouchers;
use App\RedeemVoucher;
use App\Plans;
use App\Delivery;
use App\HotDealCategory;

class ApiController extends Controller
{
	public function voucherUniqueId($voucherId , $merchantId)
	{
		$RedeemPaidVouchers = RedeemPaidVouchers::whereId($voucherId)->first();

		if( $RedeemPaidVouchers != null && $RedeemPaidVouchers->count() > 0 ){
			$unique_voucher_id = $RedeemPaidVouchers->voucherId;
			if( strpos( $unique_voucher_id , 'VCH' ) !== false ){
				$voucherDetails = RedeemPaidVouchers::whereId($voucherId)->with('voucher')->first();
			}else{
				$voucherDetails = RedeemPaidVouchers::whereId($voucherId)->with('voucher_details')->first();
			}
			return ['status' => 'success' , 'message' => "success" ,'data' => $voucherDetails];
		}else{
			return ['status' => 'fail' , 'message' => 'error'];
		}

	}
	public function registerUser(Request $request)
	{
// 		$validation = $request->validate([
// 			'username' 	=> 	'required', 
// 			'mobile'	=>	'required|unique:users|max:12|min:10',
// 			'email'		=>	'required|unique:users|email',
// 			'password'	=>	'required|min:6',
// 		]);
		
		$currentDate = date("Y-m-d");

        $model = SubscribePlan::where( 'from' , '<=' ,$currentDate )->where( 'to' , '>=' ,$currentDate )->with('plan')->first();
        
        if( $model != null ){
            $data = [
					'name' 		=> $request->username,
					'mobile' 	=> $request->mobile,
					'email' 	=> $request->email,
					'password' 	=> Hash::make($request->password),
					'plan_id'   => $model->plan_id,
					'isFreePlan'=> $model->id,
					'expired_on'=> $model->to,
					'role_id'   => 2
				];
        }else{
            $data = [
					'name' 		=> $request->username,
					'mobile' 	=> $request->mobile,
					'email' 	=> $request->email,
					'password' 	=> Hash::make($request->password),
					'role_id'   => 2
				];
        }
        
        $storeUser = User::create($data);
        
        $updatedUser = User::where('id' , $storeUser->id)->update(['customer_unique_id' => 'CUS00'.$storeUser->id]);
        $UserAfterUpdate = User::where('id' , $storeUser->id)->first();
		$uniqueId = $UserAfterUpdate->customer_unique_id;

		if( $storeUser ){
			$data = array(	
							'name'=>"Discount India",
							'data' => $request->all()
						);
			\Mail::send(['text'=>'registermail'], $data, function($message) {
				$message->to('support@thediscountindia.com', 'Discount India')->subject('New User Register');
				$message->from('discountindia98@gmail.com','Discount India');
			});
			$userModel = User::where('customer_unique_id' , $uniqueId)->first();
			return ['status' => 'success' , 'message' => "success" ,'data' => $userModel];

		}else{
			return ['status' => 'fail' , 'message' => 'error'];
		}
	}
    
	public function loginUser(Request $request)
	{
		$validate = $request->validate([
			'mobile' => 'required',
			'password' => 'required|min:6'
		]);
		$data = ['mobile' => $request->mobile];
		$checkIfUser = User::where($data)->first();

		if( $checkIfUser == null ){
			$data = ['email' => $request->mobile];
			$checkIfUser = User::where($data)->first();			
		}
		$toDayDate = date('Y-m-d');

		if( $toDayDate > $checkIfUser ){
			return ['status' => 'fail' , 'message' => 'Your Plan is expired'];
		}else{
			if( $checkIfUser != null ){
				$checkPassword = Hash::check($request['password'] , $checkIfUser['password']);

				if( $checkPassword == true ){
				    if( $checkIfUser->isFreePlan != 0 ){
    				    $currentDate = date("Y-m-d");
    				    $expiredOn = $checkIfUser->expired_on;
    				    if($currentDate < $expiredOn){
				            return ['status' => 'success' , 'message' => 'success' , 'data' => $checkIfUser];
    				    }else{
				            return ['status' => 'fail' , 'message' => 'Your Free Plan is expired. please contact support for voucher'];
    				    }
    				   
                        //$model = SubscribePlan::where(['id' => $checkIfUser->isFreePlan])->first();
    				    // if( $model != null ){
    				    //     $to = $model->to;
    				    //     if( $currentDate <= $to ){
    				    //         return ['status' => 'success' , 'message' => 'success' , 'data' => $checkIfUser];
    				    //     }else{
    				    //         return ['status' => 'fail' , 'message' => 'Your Free Plan is expired. please contact support for voucher'];
    				    //     }
    				    // } 
				    }
                    return ['status' => 'success' , 'message' => 'success' , 'data' => $checkIfUser];
				}else{
					return ['status' => 'fail' , 'message' => 'Wrong username and password'];
				}
			}else{
					return ['status' => 'fail' , 'message' => 'Wrong Mobile number and password'];
			}
		}
	}

	//get categories
	public function Categories()
	{
		$categories = Categories::select('id','name','icon')->orderBy('order', 'ASC')->get();
		return ['status' => 'success' , 'data' => $categories];
	}

	//get city
	public function getCities()
	{
		$city = Cities::select('id','city')->get();
		return ['status' => 'success' , 'data' => $city];
	}

	//get offers
	public function getOffers(Request $request)
	{
		$city = $request->city;
		$catId = $request->catId;
		$city = Cities::where('city', $city)->first();
		$offers = [];
		if( $city != null){
			$cityId = $city['id'];
			$offers = Offers::where([ 'category' => $catId , 'city' => $cityId ])->orderBy('order', 'ASC')->get();
			$processedOffer = [];

			foreach($offers as $k => $v){
				$offers[$k]['attachment'] = json_decode($v->attachment , true);
			}
		}

		return ['status' => 'success' , 'data' => $offers];
	}

    //get User Profile
    public function getUserProfile($userId){
        $decodeUserId = $userId;

        $user = User::where('customer_unique_id' , $decodeUserId)->with('plan')->first();
        if( $user != null ){
            return ['status' => 'success' , 'data' => $user];
        }else{
            return ['status' => 'fail' , 'message'=> 'User Not foound'];
        }
    }	

    public function getVouchers($OfferId, $plan_id, $user_id)
    { 
		if( $plan_id != null && $plan_id != 'null' ){

			$getVouchersIdByUserPlanId = PlanVoucherMap::select('vooucher_id')->where('plan_id' , $plan_id)->get()->map(function($query){
	    		return $query->vooucher_id;
	    	});

			$offers = 	Offers::where('id' , $OfferId)->with(['vouchers' => function($query) use ($user_id, $getVouchersIdByUserPlanId){
				    		return $query->orderBy('order' , 'ASC')->where(['status' => 1])->whereIn('id' , $getVouchersIdByUserPlanId)->with(['userVoucher' => function($que) use ($user_id){
				    			return $que->where('customer_unique_id' , $user_id)->get();
				    		}])->get();
				    	},'category'])->get();
		}else{
			$offers=Offers::where('id' , $OfferId)->with(['vouchers' => function($query){
			    $query->orderBy('order' , 'ASC')->where(['status' => 1])->get();
			} ,'category'])->get();
		}
	    	return ['status' => 'success' , 'data' => $offers]; 

    }

    //get hot deals
    public function getHotDeals($userId , $cityId)
    {
        $city = Cities::where('city' , $cityId)->first();
    	$hotDeals = collect();
    	
        if($city != null){
            $user = User::select('plan_id')->where('customer_unique_id' , $userId)->first();
            
        	if( $user != null ) {
        		$userPlan = $user->plan_id;
    
        		if( $userPlan != null && $userPlan != "null" ){
        			$voucherDeals = PlanVoucherMap::where('plan_id', $userPlan)->get()->map(function($query) {
    	    			return $query->vooucher_id;
    	    		});

    	    		if( $voucherDeals != null && $voucherDeals != 'null' ){
    	    			$planVoucherIds = $voucherDeals->toArray();
    		    		$voucherUniqueId = 	Vouchers::whereIn('id' , $planVoucherIds)->get()->map(function($query){
    							    			return $query->voucher_unique_id;
    							    		});
    			    	$hotDeals = HotDeals::orderBy('order','ASC')->whereIn('voucher_id' , $voucherUniqueId)->with(['vooucherDetails' => function($query) use ($userId){
    			    		return $query->with(['userVoucher' => function($query) use ($userId){
    			    			return $query->where('customer_unique_id' ,$userId )->get();
    			    		} ,'Offer'])->get();
    			    	}])->get();
    	    		}
        		}else{
        			$hotDeals = HotDeals::orderBy('order','ASC')->with(['vooucherDetails' => function($query) use ($userId){
    		    		return $query->with(['userVoucher' => function($query) use ($userId){
    		    			return $query->where('customer_unique_id' ,$userId )->get();
    		    		} ,'Offer'])->get();
    		    	}])->get();
        		}
        	}
        	$data = $hotDeals->map(function($query){
        		return $query->voucher_id;
        	});
        }
         $cityDeals = collect();
        // $cityId = $city->id;
        // $hotDeals = HotDeals::with(['vooucherDetails' => function($query) use ($userId, $cityId){
    		  //  		return $query->with(['userVoucher' => function($query) use ($userId , $cityId){
    		  //  			return $query->where('customer_unique_id' ,$userId )->get();
    		  //  		} ,'Offer' => function($query) use ($cityId){ 
    		  //  		    return $query->where('city' , $cityId)->get();
    		  //  		}])->get();
    		  //  	}])->get();
    		  
        foreach($hotDeals as $k => $v){
            if( $v->vooucherDetails != null ){
                if($v->vooucherDetails->Offer){
                    if($v->vooucherDetails->Offer->city != null){
                        if($v->vooucherDetails->Offer->city == $city->id){
                            $cityDeals[] = $v;
                        }     
                    }
                }
            }
        }
        return collect($cityDeals);
    	return $hotDeals;
    }
    
    public function getPremiumDeals( $cityName )
    {
    	$cityId = Cities::where('city' , $cityName)->first();
    	if( $cityId != null ) {
    		$selectedCityId = $cityId->id;
    		$paidVoucher = collect();

			$offers = Offers::select('id')->where('city' , $selectedCityId)->get()->map(function($query){
				return $query->id;
			});
			if( $offers != null ){
				//according to city
				$offersId = $offers->toArray();
				$paidVoucher = PaidVouchers::whereIn('voucher_of' , $offersId)->where('valid_date' ,'>' ,date('Y-m-d'))->get();
			}
			return ['status' => 'success' , 'data' => $paidVoucher];
    	}
		return ['status' => 'fail' , 'message' => 'something went wrong.'];

    }
    
    public function getSharedVouchers ( $userId )
    {
    	$offers = ShareVoucher::where('userId' , $userId)->with(['user' , 'voucher'])->get();
		return ['status' => 'success' , 'data' => $offers];

    }

    public function getUniqueVoucher($vouchersId){

    	if (strpos($vouchersId, 'paid_2') !== false) {
    		$explode = explode('paid_' , $vouchersId);
    		$voucherId = $explode[1];
    		$voucher = RedeemPaidVouchers::where('id' , $voucherId)->with(['voucher_details' => function($query){
    			return $query->with(['voucher' , 'Offer']);
    		}])->first();
		}else{
	    	$voucher = Vouchers::where('voucher_unique_id' , $vouchersId)->with(['Offer' => function($query){
	    		return $query->with(['category']);
	    	}])->first(); 
		}
	    	return ['status' => 'success' , 'data' => $voucher];

    }
    public function redeemVoucher($voucherId , $customerId , $userId)
    {
    	$voucherDetails = Vouchers::where(['voucher_unique_id' => $voucherId])->with(['offer'])->first();
    	$user = User::where('offerId' , $voucherDetails->voucher_of)->first();

    	if( $user != null ){

	    	if( $voucherDetails != null ){
	    		$voucherOf = $voucherDetails->voucher_of;

	    		if( $user->id == $userId ){
		    		$user = User::where('customer_unique_id' , $customerId)->first();
		    		$redVoucher = RedeemVoucher::where(['voucher_unique_id' => $voucherOf , 'customer_unique_id' => $customerId,'voucher_unique_id' => $voucherId])->first();
		    		if( $redVoucher != null ){
		    			return ['status' => 'fail' , 'message' => 'Customer already redeem that voucher'];
		    		}
					RedeemVoucher::create([
						'customer_unique_id' => $customerId,
						'voucher_unique_id' => $voucherId,
						'status' => 1,
						'redeem_by' => $voucherOf  
					]); 
			
					$additionalData = [];
					$additionalData['customer_unique_id'] = $customerId;
					$additionalData['user']['name'] = $user['name'];
					$additionalData['voucher']['title'] = $voucherDetails['title'];
					$additionalData['voucher']['offer']['title'] = $voucherDetails['offer']['title'];

					$data = array(
								'name'=>"Discount India",
								'data' => $additionalData
							);

					\Mail::send(['text'=>'mail'], $data, function($message) {
						$message->to('support@thediscountindia.com', 'Discount India')->subject('Voucher Redeemed');
						$message->from('discountindia98@gmail.com','Discount India');
					});
			    	return ['status' => 'success' , 'data' => $data];
	    		}else{
					return ['status' => 'fail' , 'message' => 'Voucher not belong to you.'];
	    		}

	    	}
			return ['status' => 'fail' , 'message' => 'unknown voucher.'];

    	}else{
			return ['status' => 'fail' , 'message' => 'No user allocted to this offer , please contact admin for support.'];
    	}
			return ['status' => 'fail' , 'message' => 'unknown error.'];
    }

    public function redeemPaidVoucher($paidVoucher , $merchantId){
    	$redeemVoucher = RedeemPaidVouchers::where('id' , $paidVoucher)->first();
    	if( $redeemVoucher != null ){
    		if( $redeemVoucher->voucherType == 'paid' ){
    			if( $redeemVoucher->status == 0 ){
    				$voucherId = PaidVouchers::whereId($redeemVoucher->voucherId)->first();
    				if( $voucherId != null ){
						
						$offerId = $voucherId->voucher_of;
						$user = User::where(['offerId' => $offerId])->first();
						$userId = $user->id;
						
						if( $userId == $merchantId ){
							$RedeemPaidVouchers = RedeemPaidVouchers::where(['id' => $paidVoucher])->update(['status' => 1]);
					    	return ['status' => 'success' , 'data' => $user];
						}else{
							return ['status' => 'fail' , 'message' => 'Voucher not belongs to you.'];
						}
						
					}else{
						return ['status' => 'fail' , 'message' => 'Voucher not available.'];
					}
    				
    			}else{
					return ['status' => 'fail' , 'message' => 'Voucher already Used.'];
    			}
    		}else{
				$voucherId = $redeemVoucher->voucherId;
				$voucher = Vouchers::where('voucher_unique_id' , $voucherId)->first();
				$offerId = $voucher->voucher_of;
				$user = User::where(['offerId' => $offerId])->first();
				$userId = $user->id;

				if( $userId == $merchantId ){
					$RedeemPaidVouchers = RedeemPaidVouchers::where(['id' => $paidVoucher])->update(['status' => 1]);					
					return ['status' => 'success' , 'data' => $user];
				}else{
					return ['status' => 'fail' , 'message' => 'Voucher not belongs to you.'];
				}
    		}
    	}
    }

    public function createPaidVoucherByadminApp(Request $request)
    {

    	$selectedTemplate = $request->selectedTemplate ;
		$title = $request->title ;
		$validDate = $request->validDate ;
		$TandC = $request->TandC ;
		$customerPrice = $request->customerPrice ;
		$hotelPrice = $request->hotelPrice ;
		$belongTo = 0;
 
		$paidVoucher = PaidVouchers::orderBy('id' , 'DESC')->first();
		if( $paidVoucher != null ){

			$explode = explode('_' , $paidVoucher->voucher_unique_id);

			$paidvouchers = ($explode[1] + 1);
			if( strlen($paidvouchers) == 1 ){
				$newPaidvoucher = '00000'.$paidvouchers;
			}
			if( strlen($paidvouchers) == 2 ){
				$newPaidvoucher = '0000'.$paidvouchers;
			}
			if( strlen($paidvouchers) == 3 ){
				$newPaidvoucher = '000'.$paidvouchers;
			}
			if( strlen($paidvouchers) == 4 ){
				$newPaidvoucher = '00'.$paidvouchers;
			}
			if( strlen($paidvouchers) == 5 ){
				$newPaidvoucher = '0'.$paidvouchers;
			}
			if( strlen($paidvouchers) == 6 ){
				$newPaidvoucher = $paidvouchers;
			}
			$paidvouchers = 'PVC_'.$newPaidvoucher;

		}else{
			$paidvouchers = "PVC_000001";
		}

		$data = [
			'title' => $title,
			'valid_date' => $validDate,
			'terms_condition' => $TandC,
			'barcode' => 0,
			'discount' => 0,
			'voucher_of' => $belongTo,
			'voucher_unique_id' => $paidvouchers,
			'voucher_template' => $selectedTemplate, 
			'custom_template' => 0,
			'customer_price' => $customerPrice,
			'hotel_price' => $hotelPrice,
			'discount_india_price' => ($customerPrice - $hotelPrice),
		];

		$createVoucher = PaidVouchers::create($data);

		return ['status' => 'success' , 'data' => []];
    }
    public function getClientVoucher($clientId)
    {
    	$paidVouchers = PaidVouchers::where('voucher_of' , $clientId)->get();
    	dd($paidVouchers);
    }
    public function getUserRedeemedVoucher($userId)
    {
    	$user = User::where('id' , $userId)->first();
            
    	if( $user != null ){
	    	if( $user->role_id != 3 ){
		    	$customerId = $user->customer_unique_id;
		    	$vouchers = RedeemVoucher::orderBy('id' ,'DESC')->where('customer_unique_id' , $customerId)->with(['voucherDetails' => function($query){
		    		return $query->with('Offer');
		    	}])->get();
		    	
		    	$paidVoucher = RedeemPaidVouchers::where('userId' , $userId)->with(['voucher' , 'voucher_details' => function($query){
		    	    return $query->with('Offer'); 
		    	}])->get();
	    	}else{
	    		$offerId = $user->offerId;
	    		$id = $user->id;
	    		$voucher = Vouchers::select('voucher_unique_id')->orderBy('id' ,"DESC")->where('voucher_of' , $offerId)->get()->map(function($query){
	    			return $query->voucher_unique_id;
	    		});
	    		if( $voucher != null ){
	    			$vouchers = $voucher->toArray();
	    		}

				$vouchers = RedeemVoucher::whereIn('voucher_unique_id' , $vouchers)->orderBy('created_at' , 'DESC')->with(['customerDetails' , 'voucherDetails'])->get();
				$paidVoucher = collect(); 
	    	}
    	}
		return ['status' => 'success' , 'data' => $vouchers ,'paid' => $paidVoucher];
    }
    
    public function getPlans()
    {
    	$plans = Plans::where('deleted_at' , null)->get();
    	return ['status' => 'success' , 'data' => $plans];
    }
    public function checkUserExist(Request $request)
    {
    	if( strlen($request->mobile) == 10 ) {
    		$otp = rand(10000 , 99999);

    		$user = User::where('mobile' , $request->mobile)->first();
    		if( $user != null ){
    			User::where('mobile' , $request->mobile)->update(['otp' => $otp]);
		    	$url = "http://sms.zipzap.in/pushsms.php?username=discount&api_password=32599eodpqmzve3q6&sender=DISIND&to=".$request->mobile."&message=Yor%20OTP%20for%20forget%20password%20is%20".$otp."&priority=11";
		    	$ch = curl_init();
			    curl_setopt($ch,CURLOPT_URL,$url);
			    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
			    $output=curl_exec($ch);
			    curl_close($ch);

				return ['status' => 'success' , 'data' => ["http://sms.zipzap.in/pushsms.php?username=discount&api_password=32599eodpqmzve3q6&sender=DISIND&to=".$request->mobile."&message=Yor%20OTP%20for%20forget%20password%20is%20".$otp."&priority=11"]];
    		}else{
				return ['status' => 'fail' , 'message' => 'No user available for this account.'];
    		}
    	}else{
			return ['status' => 'fail' , 'message' => 'No user available for this account.'];
    	}
    }
    public function checkOtpVerify(Request $request)
    {
    	$mobile = $request->mobile;
    	$otp = $request->otp;

    	$user = User::where('mobile' , $mobile)->first();
    	if( $user != null ){
    		$userOtp = $user->otp;
    		if( $otp == $userOtp ){
    			return ['status' => 'success' , 'data' => []];
    		}else{
				return ['status' => 'fail' , 'message' => 'Wrong OTP.'];
    		}
    	}else{
			return ['status' => 'fail' , 'message' => 'User not available.'];
    	}
    }
    
    public function updatePassword(Request $request)
    {
    	$mobile = $request->mobile;
    	$password = $request->password;
    	$confirmPassword = $request->confirmPassword;

    	if( $password == $confirmPassword ){
	    	User::where('mobile' , $mobile)->update(['password' => Hash::make($password)]);
	    	return ['status' => 'success' , 'data' => []] ;
    	}else{
    		return ['status' => 'fail' , 'message' => 'sorry something went wrong'];
    	}
    }

    public function getPaidVoucherDetails($id)
    {
    	$voucher = PaidVouchers::whereId($id)->first();
    	return ['status' => 'success' , 'data' => $voucher];
    }

    public function getPaidVoucherList($id)
    {
    	$voucher = RedeemPaidVouchers::where('userId' , $id)->where('status' , 0)->where('voucherType' ,'paid' )->with(['voucher_details'=> function($query){
    		return $query->with(['Offer']);
    	}])->get();

    	return ['status' => 'success' , 'data' => $voucher];
    }
    public function getSharedPaidVoucherList($id)
    {
    	$voucher = RedeemPaidVouchers::where('userId' , $id)->where('status' , 0)->where('voucherType' ,'shared')->with(['voucher'=> function($query){
    		return $query->with(['Offer']);
    	}])->get();

    	return ['status' => 'success' , 'data' => $voucher];
    }

    public function getShareVoucherDetails($id)
    {
    	$voucher = ShareVoucher::where("voucherId" , $id)->with(['user' , 'voucher' => function($query){
    		return $query->with('Offer');
    	}])->first();
    	return ['status' => 'success' , 'data' => $voucher];
    }
    
    public function updatePaymentStatus(Request $request)
    {
    	$voucher = RedeemPaidVouchers::create([
    		'voucherId' => $request->voucherId,
    		'paymentId' => $request->paymentId,
    		'voucherType' => $request->voucherType,
    		'userId' 	=> $request->userId,
    		'status' 	=> 0
    	]);
    	return ['status' => 'success' , 'data' => $voucher];
    }
    public function updateToken(Request $request)
    {
    	$token = $request->token;
    	$userId = $request->userId;

    	$updateUser = User::where(['id' => $userId])->update(['token' => $token]);
    	$user = User::where(['id' => $userId])->first();
    	return ['status' => 'success' , 'data' => $user];
    }
    public function getDelivery($city){
        $selectedCity = Cities::where('city' , 'like' , '%'.$city.'%' )->first();
        if( $selectedCity != null ){
            $delivery = Delivery::where(['city' => $selectedCity->id])->get();
            return ['status' => 'success' , 'data' => $delivery];
        }else{
            return ['status' => 'success' , 'data' => []];    
        }
    }
    public function getsubCategory(){
        $subCat = Subcategory::orderBy('title' , 'ASC')->get();
        return ['status' => 'success' , 'data' => $subCat];
    }
    
    public function getSubCategoryDetailsById($subCatId){
        $data = Subcategory::where(['id' => $subCatId])->get();
        $offersArray = collect();
        if( $data->count($data) > 0 ){
            $offersIdArray = json_decode($data[0]['offers']);
            $offersArray = Offers::whereIn('id' , $offersIdArray)->get();
        }
        return ['status' => 'success' , 'offers' => $offersArray];
    }
    public function gettopslider(){
        $data = Topslider::where('active' , '1')->orderBy('id','DESC')->get();
        return ['status' => 'success' , 'slider' => $data];
    }
    public function getHotDealsCategory($city){
        $city = Cities::where('city' , $city )->first();
        $currentCityMerchants = Offers::select('id')->where('city' , $city->id)->get()->map(function($query){
            return $query->id;
        });
        
        $currentCityMerchantsArray = $currentCityMerchants->toArray();

        $hotDealsCategory = HotDealCategory::get();
        foreach($hotDealsCategory as $k => $v){
            if( $v->hot_deal_id != null ){
                $hotDealsId = json_decode($v->hot_deal_id , true);
                
                $hotDeals = HotDeals::whereIn('id' , $hotDealsId )->with(['vooucherDetails'])->get();

                $hotDealsVoucher = $hotDeals->map(function($query){
                    return $query->voucher_id;
                });    

                $hotDealsVoucherArray = $hotDealsVoucher->toArray();
                $listVouchers = Vouchers::whereIn('voucher_unique_id' , $hotDealsVoucherArray)->with(['vooucherDetails'])->get();
                $availableVoucher = [];

                foreach($listVouchers as $ke => $val){
                    if( array_key_exists($val->voucher_of , $currentCityMerchantsArray ) ){
                        $availableVoucher[] = $val; 
                    }
                }
                
                $hotDealsCategory[$k]['vouchers'] = $availableVoucher;
            }
        }
        
        return ['status' => 'success' , 'data' => $hotDealsCategory]; 
    
    }
}