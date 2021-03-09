<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Vouchers;
use App\Http\Requests\CreateVouchersRequest;
use App\Http\Requests\UpdateVouchersRequest;
use Illuminate\Http\Request;
use App\Categories;
use App\Plans;
use App\User;
use App\Offers;
use Illuminate\Database\Schema\Blueprint;
use App\PlanVoucherMap;

class VouchersController extends Controller {

	/**
	 * Display a listing of vouchers
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
    	$user = User::where('role_id' , 2)->get();
        $vouchers = Vouchers::with(['Offer'])->get();

		return view('admin.vouchers.index', compact('vouchers' , 'user'));
	}

	/**
	 * Show the form for creating a new vouchers
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    $Categories = Categories::all();
	    $plans = Plans::all();
	    return view('admin.vouchers.create' , compact('Categories', 'plans'));
	}

	/**
	 * Store a newly created vouchers in storage.
	 *
     * @param CreateVouchersRequest|Request $request
	 */
	public function store(CreateVouchersRequest $request)
	{
		$createVoucher = Vouchers::create($request->all());
		$uniqueId = 'VCH00'.$createVoucher->id;
		
		$upadte = Vouchers::where('id' , $createVoucher->id)->update(['voucher_unique_id' => $uniqueId]);

		foreach ( $request->plan_id as $key => $value ) {
			PlanVoucherMap::create([
				'vooucher_id' => $createVoucher->id,
				'plan_id' => $value,
				'string' => 1,
			]);
		}

		$user = User::where('token' ,'!=', null)->whereIn('plan_id' , $request->plan_id)->get()->map(function($query){
			return $query->token;
		});
		
		$allTokenArray = $user->toArray();
		$this->sendPushNotification( $allTokenArray , "New Voucher Added." , $uniqueId );

		return redirect()->route(config('coreadmin.route').'.vouchers.index');
	}

	public function sendPushNotification( $device_id , $message , $redirect_url )
	{
		$url = 'https://fcm.googleapis.com/fcm/send';
        $apikey = 'AAAAHLZRooM:APA91bHEZPg76ADSb3BiMDu1JQHjjJwi0fILahYaR_oBumG-tdjdmBZomBEt7kwWYj2C9LF4QXBbNAEpND0E2JNIRdIACy7xwrJBrZ7qeramK317INpTTt2GmJJSwIoi61mocXkBV485';
        
        $fields = array(
        	'registration_ids' => $device_id,
        	'notification'=>['title' => 'The Discount India' , 'body' => $message, 'click_action' => 'FCM_PLUGIN_ACTIVITY' , 'sound' => 'default' ],
        	'data' => [
			    // 'message' 	=> 'This is message',
				// 'title'		=> 'This is a title. title',
				// 'subtitle'	=> 'This is a subtitle. subtitle',
				// 'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
				// 'body' => 'This is body',
				'redirect_url' => $redirect_url,
				'vibrate'	=> 1,
				'sound'		=> 1,
				'priority' => 1,
				'largeIcon'	=> 'large_icon',
				'smallIcon'	=> 'small_icon'
        	]
        );
        //
        $headers = array(
            'Authorization: key=' . $apikey,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // Execute post
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);



    	return false;
	}

	/**
	 * Show the form for editing the specified vouchers.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{

		$selectedPlans = PlanVoucherMap::where('vooucher_id' , $id)->get()->map(function($query){
			return $query->plan_id;
		});
		$currentPlans = [];
		if( $selectedPlans != null ){
			foreach( $selectedPlans as $k => $v ){
				$currentPlans[] = $v;
			}
		}

		$vouchers = Vouchers::find($id);
	    $plans = Plans::all();

		return view('admin.vouchers.edit', compact('vouchers','plans' ,'currentPlans'));
	}

	/**
	 * Update the specified vouchers in storage.
     * @param UpdateVouchersRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateVouchersRequest $request)
	{
		// foreach( $request->all() as $k => $v ){
		// 	if( gettype($v) == 'array'){
		// 		$request[$k] = json_encode($v);
		// 	}else{
		// 		$request[$k] = $v;
		// 	}
		// }
		PlanVoucherMap::where(['vooucher_id' => $id])->delete();
		
		foreach ( $request->plan_id as $key => $value ) {
			PlanVoucherMap::create([
				'vooucher_id' => $id,
				'plan_id' => $value,
				'string' => 1,
			]);
		}

		$vouchers = Vouchers::findOrFail($id);
		$vouchers->update($request->all());
		return back();
		// return redirect()->route(config('coreadmin.route').'.vouchers.index');
	}

	/**
	 * Remove the specified vouchers from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Vouchers::destroy($id);

		return redirect()->route(config('coreadmin.route').'.vouchers.index');
	}

    /**
     * Mass delete function from index page
     * @param Request $request
     *
     * @return mixed
     */
    public function massDelete(Request $request)
    {
        if ($request->get('toDelete') != 'mass') {
            $toDelete = json_decode($request->get('toDelete'));
            Vouchers::destroy($toDelete);
        } else {
            Vouchers::whereNotNull('id')->delete();
        }

        return redirect()->route(config('coreadmin.route').'.vouchers.index');
    }

    public function deactivateVoucher($voucherId){
        Vouchers::where('id' , $voucherId)->update(['status' => 0]);
        return back();
    }
    
    public function activateVoucher($voucherId){
        Vouchers::where('id' , $voucherId)->update(['status' => 1]);
        return back();
    }

}
