<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\Offers;
use App\Notifications;
use App\Vouchers;
use App\Plans;
use App\Categories;
use App\RedeemVoucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Session;
use Auth;

class ReportController extends Controller
{
   public function getMerchantReports(){
       
       $users = User::with(['offers' => function($query){
            return $query->with(['vouchers' => function($voucherQuery){
                return $voucherQuery->with(['vocuherDetails']);
            } , 'categoryDetails'])->has('categoryDetails');
       }])->where('customer_unique_id' , null)->has('offers')->get();
        
        
        foreach( $users as $k => $v ){
            $data = 0;
            foreach($v->offers->vouchers as $key => $value){
                if( $value->vocuherDetails != null ){
                      $data = ($data+$value->vocuherDetails->count());
                }
            }
            $users[$k]['userRedeemedVouchers'] = $data; 
        }
       return View('admin.reports.index' , compact('users'));
    }
    public function voucherReport(){
        // $plans = Plans::with(['users'])->get();
        // dd($plans);
        $data = Vouchers::with(['Offer' ,'vocuherDetails' => function($query){
            return $query->with(['customerDetails' => function($res){
                $res->with(['plan'])->has('plan');    
            } , 'voucherDetails' ])->has('customerDetails');
            
        }])->has('vocuherDetails')->get();
        // $data = User::with('redeemedVoucherDetail')->where('customer_unique_id' , 'CUS001028')->limit(10)->get();
        // $data = RedeemVoucher::with(['voucherDetails' , 'listCustomerDetails'])->whereDate('created_at' , '>=' , '2020-06-01')->limit(11)->get();
        return view('admin.reports.voucherReport' , compact('data'));
    }
}