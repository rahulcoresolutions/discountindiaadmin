<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\Offers;
use App\Notifications;
use App\Vouchers;
use App\Plans;
use App\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Session;
use Auth;

class UsersController extends Controller
{
    /**
     * Show a list of users
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::orderBy('id' , 'DESC')->with('plan')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show a page of user creation
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::pluck('title', 'id');
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Insert new user into the system
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['status'] = 0;
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);

        return redirect()->route('users.index')->withMessage(trans('coreadmin::admin.users-controller-successfully_created'));
    }

    /**
     * Show a user edit page
     *
     * @param $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user   = User::findOrFail($id);
        $roles  = Role::pluck('title', 'id');
        $plan   = Plans::pluck('title', 'id');
        $offers = Offers::select('id' ,'title')->get();

        return view('admin.users.edit', compact('user', 'roles', 'plan','offers'));
    }

    /**
     * Update our user information
     *
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {

        $user = User::findOrFail($id);
        $userCurrentPlan = $user->plan_id;

        $input = $request->all();
        if( $request->has('password') ){
            if( $request->password != null ){
                $input['password'] = Hash::make($input['password']);
            }else{
                unset($input['password']);
            }
        }
        $input['offerId'] = $request->belongs_to;


        $plan_id = $request->plan_id;
        if( $plan_id != $userCurrentPlan ){
           
            $plan = Plans::where('id' , $plan_id)->first();
            if( $plan != null ){
                $expireDate = date('Y-m-d', strtotime('+'.$plan->valid.' months'));
                $input['expired_on'] = $expireDate;
            }else{
                 
                // $expireDate = date('Y-m-d', strtotime('+'.$planMonth.' months'));
                $input['expired_on'] = '2027-10-29';
            }
            
        }
        $user->update($input);
        return redirect()->route('users.index')->withMessage(trans('coreadmin::admin.users-controller-successfully_updated'));
    }

    /**
     * Destroy specific user
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
    */
    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        User::destroy($id);

        return redirect()->route('users.index')->withMessage(trans('coreadmin::admin.users-controller-successfully_deleted'));
    }

    public function activeUser($id)
    {
        User::where(['id' => $id])->update(['status' => 1]);
        return back();
    }
    
    public function deactivateUser($id)
    {
        User::where(['id' => $id])->update(['status' => 0]);
        return back();
    }

    public function getUserPlan($id){
        $user = User::where('id' , $id)->first();
        return View('admin.plans.changePlan' , compact('user'));
    }
    
    public function loginUser($id){
        Session()->flush();
        return redirect()->route('login.user');
    }
    
    public function dashboard(){
        return view('admin.dashboard');
    }
    function upcommingRenewals(){
        $users = User::orderBy('id' , 'DESC')->with(['plan'])->where('plan_id' ,'!=', null)->whereMonth('expired_on' , date('m'))->get();
        return view('admin.upcommingRenewal' , compact('users'));
    }
    public function listNotification()
    {
        $notification = Notifications::orderBy('id', 'DESC')->get();
        return view('admin.notification.index' , compact('notification'));
    }
    public function createNotification()
    {
        $voucher = Vouchers::select(['voucher_unique_id' , 'title'])->get();
        return view('admin.notification.create' , compact('voucher'));
    }
    public function storeNotifications(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'redirect_url' => 'required'
        ]);

        Notifications::create([
            'message' => $request->message,
            'redirect_to' => $request->redirect_url,
            'status' => 1
        ]);

        $user = User::select('token')->where('token' ,'!=', null)->get()->map(function($query) {
        	return $query->token;
        });

        $this->push_notification_android($user->toArray() , $request->message , $request->redirect_url);
        return back();
    }
    
    public function sendNotification( $message , $device_token ,$redirect_url ){
        
        foreach($device_token as $k => $v){
            $url = "https://fcm.googleapis.com/fcm/send";
            // $token = "dnOitEw5TCCzKf4z2wxUgg:APA91bHcX46oZw3MYk14Hz4SSItpfWbwEkIBqstfuLAfDATIFZXy-bLSdkYFY6QWMUfzTPNjHV4bEa8xsrhVfcRGffU502DKBX70C33izCJIExfmnOkJv6HBaDopfK6nMEe2n_4qyOxN";
            $serverKey = 'AAAAMmLzM3o:APA91bFsD1hk-_iq5eT1FbnpS5f8p8CLtA5S3y5VZnBnTHAae8ieSopQzafZYXpbtvvx6AScfsG9TF3mZit4nqqDlOHODGZI7fzGvntBR2gA86TNbVwVUK4pxYWpQyA9OtbqBxSy-cND';
            $title = "Message";
            $body = $message;
            $notification = array('title' =>$title,'data' => ['redirect_url' => $redirect_url] ,'body' => $body, 'sound' => 'default', 'badge' => '1');
            $arrayToSend = array('to' => $v, 'notification' => $notification,'priority'=>'high','data' => ['redirect_url' => $redirect_url]);
            $json = json_encode($arrayToSend);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key='. $serverKey;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
    
            $response = curl_exec($ch);
           
            if ($response === FALSE) {
                die('FCM Send Error: ' . curl_error($ch));
            }
            curl_close($ch);
            return $response;    
        }
        
    }

    function push_notification_android($device_id,$message,$redirect_url){
        $this->sendNotification($message  , $device_id , $redirect_url);
        return back();

    	$url = 'https://fcm.googleapis.com/fcm/send';
        $apikey = 'AAAAMmLzM3o:APA91bFsD1hk-_iq5eT1FbnpS5f8p8CLtA5S3y5VZnBnTHAae8ieSopQzafZYXpbtvvx6AScfsG9TF3mZit4nqqDlOHODGZI7fzGvntBR2gA86TNbVwVUK4pxYWpQyA9OtbqBxSy-cND';
        
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
        
        
        dd($result);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
    
        // Close connection
        curl_close($ch);



    	return false;
        $url = 'https://fcm.googleapis.com/fcm/send';
        $api_key = 'AAAAHLZRooM:APA91bHEZPg76ADSb3BiMDu1JQHjjJwi0fILahYaR_oBumG-tdjdmBZomBEt7kwWYj2C9LF4QXBbNAEpND0E2JNIRdIACy7xwrJBrZ7qeramK317INpTTt2GmJJSwIoi61mocXkBV485';
                    
        $fields = array (
            'to' => $device_id,
            'data' => array (
                "message" => $message
            )
        );

        //header includes Content type and api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$api_key
        );
                    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        
        curl_close($ch);
        return $result;
    }

    public function notificationUpdateStatus($id)
    {
        Notifications::whereId($id)->update([ 'status' => 0 ]);
        return back();
    }
    
    public function sortCategory(Request $request){
        $dataId = $request->dataId;
        $dataOrder = $request->dataOrder;
        
        sort($dataOrder);
        $combinedData = array_combine($dataId , $dataOrder);

        foreach($combinedData as $k => $v){
            Categories::where(['id' => $k])->update(['order' => $v]);
        }
        return back();
    }
    public function listMerchants($offerId){
        $listVoucher = Vouchers::where('voucher_of' , $offerId)->orderBy('order' , 'ASC')->get();
        return view('admin.sortMerchants.index' , compact('listVoucher'));
    }
    public function sortMerchantVocuher(Request $request){
        foreach( $request->dataId as $k => $v ){
            Vouchers::where(['id' => $v])->update(['order' => ($k+1)]);
        }
        return ['status' => true];
    }
}