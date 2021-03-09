<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\RedeemVoucher;
use App\Http\Requests\CreateRedeemVoucherRequest;
use App\Http\Requests\UpdateRedeemVoucherRequest;
use Illuminate\Http\Request;
use Mail;
use App\User;
use App\Vouchers;
use App\PlanVoucherMap;
use Auth;
use Session;

class RedeemVoucherController extends Controller {

	/**
	 * Display a listing of redeemvoucher
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index()
    {
        $redeemvoucher = RedeemVoucher::where('redeem_by' , Auth::user()->id)->orderBy('id' , 'desc')->with('customerDetails','voucherDetails')->get();

		return view('admin.redeemvoucher.index', compact('redeemvoucher'));
	}

	public function getVoucherDetails(Request $request)
	{
		$voucherId = $request->voucher_unique_id;
		$customerId = $request->customer_unique_id;
		$voucherDetails = Vouchers::where(['voucher_unique_id' => $voucherId])->with(['Offer'])->first();
		if($voucherDetails != null){
			return view('admin.redeemvoucher.details' , compact('voucherDetails', 'customerId'));
		}else{
			return back()->withErrors(array('message' => 'invalid data.'));
		}
	}
	public function create()
	{	    
	    return view('admin.redeemvoucher.create');
	}
	public function store(CreateRedeemVoucherRequest $request)
	{
		$request['voucher_unique_id'] = strtoupper($request->voucher_unique_id);
		$request['customer_unique_id'] = strtoupper($request->customer_unique_id);
		$request['redeem_by'] = Auth::user()->id;

        
		$hasVoucher = Vouchers::where(['voucher_unique_id' => $request->voucher_unique_id])->with(['offer'])->first();
		$hasCustomer = User::where(['customer_unique_id' => $request->customer_unique_id ])->first();
          
		if( $hasCustomer != null && $hasVoucher != null ){
			$request['user'] = $hasCustomer->toArray();
			$request['voucher'] = $hasVoucher->toArray();

            if( $hasCustomer->expired_on > date('Y-m-d') ){
                $alreadyRedeem = RedeemVoucher::where(['customer_unique_id' => $request->customer_unique_id , 'voucher_unique_id' => $request->voucher_unique_id])->first();
    			if( !$alreadyRedeem ){
    				$redeemed = RedeemVoucher::create($request->all());
    
    
    				if( $redeemed ){
    
    					$data = array(	
    								'name'=>"Discount India",
    								'data' => $request->all()
    							);
    
    					\Mail::send(['text'=>'mail'], $data, function($message) {
    						$message->to('support@thediscountindia.com', 'Discount India')->subject('Voucher Redeemed');
    						$message->from('discountindia98@gmail.com','Discount India');
    					});
    					Session::flash('successVoucher' , "Voucher Redeem Successfully");
    					// $redeemvoucher = RedeemVoucher::where('redeem_by' , Auth::user()->id)->get();
    
    					// return view('admin.redeemvoucher.index', compact('redeemvoucher'));
    					return $this->index();
    				}
    
    				return redirect()->route(config('coreadmin.route').'.redeemvoucher.index');
    			}else{
    				return Redirect::back()->withErrors([ 'Voucher is already redeemed by user']);
    			}   
            }else{
                return Redirect::back()->withErrors([ 'User Plan Expired , Ask him to renew the plan. contact no. 8427138252']);
            }
			
		}else{
			return Redirect::back()->withErrors([ 'Data is not correct']);
		}
	}
	public function edit($id)
	{
		$redeemvoucher = RedeemVoucher::find($id);
	    
	    
		return view('admin.redeemvoucher.edit', compact('redeemvoucher'));
	}
	public function update($id, UpdateRedeemVoucherRequest $request)
	{
		$redeemvoucher = RedeemVoucher::findOrFail($id);
		$redeemvoucher->update($request->all());

		return redirect()->route(config('coreadmin.route').'.redeemvoucher.index');
	}
	public function destroy($id)
	{
		RedeemVoucher::destroy($id);

		return redirect()->route(config('coreadmin.route').'.redeemvoucher.index');
	}
    public function massDelete(Request $request)
    {
        if ($request->get('toDelete') != 'mass') {
            $toDelete = json_decode($request->get('toDelete'));
            RedeemVoucher::destroy($toDelete);
        } else {
            RedeemVoucher::whereNotNull('id')->delete();
        }

        return redirect()->route(config('coreadmin.route').'.redeemvoucher.index');
    }
    public function cloneVoucher($voucherId){
        $voucher = Vouchers::where('id' , $voucherId)->first();
        if($voucher != null){
            //PlanVoucherMap         
            $plans = PlanVoucherMap::select('plan_id')->where('vooucher_id' , $voucher->id)->get()->map(function($query){
                return $query->plan_id;
            });
            
            $createdData = [
                            	'title' => $voucher->title,
                            	'valid_date' => $voucher->valid_date,
                            	'terms_condition' => $voucher->terms_condition,
                            	'barcode' => $voucher->barcode,
                            	'discount' => $voucher->discount,
                            	'voucher_of' => $voucher->voucher_of,
                            	'voucher_template' => $voucher->voucher_template
                            ];
    	
            
            $model = Vouchers::create($createdData);
            $lastInsertedId = $model->id;
            Vouchers::where('id' , $lastInsertedId)->update(['voucher_unique_id' => 'VCH00'.$lastInsertedId]);
            
            if( $plans != null ){
                $dataplan = $plans->toArray();
                $countdata = count($plans->toArray());

                for($i = 0 ; $i < $countdata ;$i++){
                    PlanVoucherMap::create([
                        'vooucher_id' => $lastInsertedId,
                        'plan_id' => $dataplan[$i],
                        'string' => 1
                    ]);
                }
                
            }
            return redirect()->back()->with('message' , "Voucher Clone Successfully");    
        }   
    }   
}