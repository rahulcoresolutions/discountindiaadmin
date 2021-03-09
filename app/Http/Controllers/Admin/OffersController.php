<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Offers;
use App\Cities;
use App\OffersSort;
use App\RedeemVoucher;
use App\Vouchers;
use App\Http\Requests\CreateOffersRequest;
use App\Http\Requests\UpdateOffersRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Categories;
use Carbon\Carbon;

class OffersController extends Controller {

	/**
	 * Display a listing of offers
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $offers = Offers::with('categoryDetails')->orderBy('order' , 'ASC')->get();
		return view('admin.offers.index', compact('offers'));
	}

	/**
	 * Show the form for creating a new offers
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    $cat = Categories::all();
	    $cities = Cities::all();
	    return view('admin.offers.create',compact('cat','cities'));
	}

	/**
	 * Store a newly created offers in storage.
	 *
     * @param CreateOffersRequest|Request $request
	 */
	public function store(CreateOffersRequest $request)
	{
	    $request = $this->saveFiles($request);
        $request['order'] = 0;
		$order = Offers::create($request->all());
        $lastInsertedId = $order->id;
        Offers::where(['id' => $lastInsertedId])->update(['order' => $lastInsertedId]);

		return redirect()->route(config('coreadmin.route').'.offers.index');
	}

	/**
	 * Show the form for editing the specified offers.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$offers = Offers::find($id);
	    $cat = Categories::all();
	    $cities = Cities::all();
	    
		return view('admin.offers.edit', compact('offers','cat','cities'));
	}

	/**
	 * Update the specified offers in storage.
     * @param UpdateOffersRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateOffersRequest $request)
	{
		$offers = Offers::findOrFail($id);
        $request = $this->saveFiles($request);

		$offers->update($request->all());

		return redirect()->route(config('coreadmin.route').'.offers.index');
	}

	/**
	 * Remove the specified offers from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Offers::destroy($id);

		return redirect()->route(config('coreadmin.route').'.offers.index');
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
            Offers::destroy($toDelete);
        } else {
            Offers::whereNotNull('id')->delete();
        }

        return redirect()->route(config('coreadmin.route').'.offers.index');
    }
    public function orderSort(Request $request){
        
        $dataId = $request->dataId;
        $dataOrder = $request->dataOrder;
        sort($dataOrder);
        $combinedData = array_combine($dataId , $dataOrder);
    
        foreach($combinedData as $k => $v){
            $hasSameOrderId = Offers::where(['id' => $k , 'order' => $v])->first();
            if($hasSameOrderId != null ){
            	if( $hasSameOrderId->count() > 0 ){
            	}else{
            		$date = Carbon::now();

            		OffersSort::create([
            			'orderId' => $k,
            			'sortId' => $v,
            			'date' => $date->format('Y-m-d'),
            			'status' => 1,
            		]);
            	}
            }else{
        		$date = Carbon::now();
        		OffersSort::create([
        			'orderId' => $k,
        			'sortId' => $v,
        			'date' => $date->format('Y-m-d'),
        			'status' => 1,
        		]);
            }
            Offers::where('id' , $k)->update(['order' => $v]);
        }


        return back();
    }
    public function offersLog()
    {
    	$offer = OffersSort::with(['offers'])->get();
    	return view('admin.offers.orderLog' , compact('offer'));
    	dd($offer);
    }
    public function getusedVoucher($id)
    {
        $offers = Offers::where('id' , $id)->with([ 'vouchers' ])->get();
        $vouchers = collect();
        if($offers->count() > 0){
            $offersData = $offers[0];
            $vouchers = Vouchers::where(['voucher_of' => $offersData['id']])->with(['vocuherDetails' => function($query){
                return $query->orderBy('id' , 'DESC')->with(['voucherDetails','customerDetails']);
            }])->get();

            return view('admin.redeemvoucher.redeemedVoucher' ,compact('vouchers' , 'id'));
        }
        return view('admin.redeemvoucher.redeemedVoucher' ,compact('vouchers'));
    }

    public function getVoucherFilterDetails(Request $request)
    {
        $id = $request->offerId;
        $from = $request->from;
        $to = $request->to;
        
        $request->validate([
            'offerId' => 'required',
            'from' => 'required',
            'to' => 'required'
        ]);

        $vouchers = Vouchers::where(['voucher_of' => $id])->with(['vocuherDetails' => function($query) use($from , $to){
            return $query->whereBetween('created_at' , [$from , $to])->orderBy('id' , 'DESC')->with(['voucherDetails','customerDetails']);
        }])->get();      
        return view('admin.redeemvoucher.redeemedVoucher' ,compact('vouchers' , 'id'));
    }
    
    public function deactivateMerchant($voucherId){
        Offers::where('id' , $voucherId)->update(['status' => 0]);
        return back();
    }
    
    public function activateMerchant($voucherId){
        Offers::where('id' , $voucherId)->update(['status' => 1]);
        return back();
    }
    
}
