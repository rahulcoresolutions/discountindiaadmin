<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\HotDeals;
use App\Http\Requests\CreateHotDealsRequest;
use App\Http\Requests\UpdateHotDealsRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Categories;
use App\Offers;
use App\Vouchers;
use App\HotDealCategory;

class HotDealsController extends Controller {

	/**
	 * Display a listing of hotdeals
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $hotdeals = HotDeals::orderBy('order' , 'ASC')->get();
		return view('admin.hotdeals.index', compact('hotdeals'));
	}

	/**
	 * Show the form for creating a new hotdeals
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    $categories = Categories::get();	    
	    $offer = Offers::get();	    
	    $vouchers = Vouchers::get();
	    return view('admin.hotdeals.create', compact('categories' , 'offer' , 'vouchers'));
	}

	/**
	 * Store a newly created hotdeals in storage.
	 *
     * @param CreateHotDealsRequest|Request $request
	 */
	public function store(CreateHotDealsRequest $request)
	{
	    $voucherId = $request->voucher_id;
	    $request['voucher_id'] = 'VCH00'.$voucherId;

		$postedData = $request->except('_token' , 'category','offers');
	    $request = $this->saveFiles($request);
	    
		$craeteHotDeal = HotDeals::create($request->all());
		$updateOfferOrder = HotDeals::where(['id' => $craeteHotDeal->id])->update(['order' => $craeteHotDeal->id]);
		return redirect()->route(config('coreadmin.route').'.hotdeals.index');
	}

	/**
	 * Show the form for editing the specified hotdeals.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$hotdeals = HotDeals::find($id);
	    
	    
		return view('admin.hotdeals.edit', compact('hotdeals'));
	}

	/**
	 * Update the specified hotdeals in storage.
     * @param UpdateHotDealsRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateHotDealsRequest $request)
	{
		$hotdeals = HotDeals::findOrFail($id);

        $request = $this->saveFiles($request);

		$hotdeals->update($request->all());

		return redirect()->route(config('coreadmin.route').'.hotdeals.index');
	}

	/**
	 * Remove the specified hotdeals from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		HotDeals::destroy($id);

		return redirect()->route(config('coreadmin.route').'.hotdeals.index');
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
            HotDeals::destroy($toDelete);
        } else {
            HotDeals::whereNotNull('id')->delete();
        }

        return redirect()->route(config('coreadmin.route').'.hotdeals.index');
    }
    
    public function sortHotItems(Request $request)
    {
    	$dataId = $request->dataId;
        $dataOrder = $request->dataOrder;
        sort($dataOrder);
        $combinedData = array_combine($dataId , $dataOrder);

        foreach($combinedData as $k => $v){
	        HotDeals::where(['id' => $k])->update(['order' => $v]);
        }
        return back();
    }
    
    public function getSubCategoryDeals(){
        $HotDealCategory = HotDealCategory::get();
        $HotDeals = HotDeals::get();
        return view('admin.hotdeals.hotdealcategory.create' , compact('HotDealCategory' , 'HotDeals'));
    }
    
    public function hotDealsVouchers($id){
        $HotDealCategory = HotDealCategory::where('id' , $id)->first();
        $hotdeals = HotDeals::get();
        return view('admin.hotdeals.hotdealcategory.edit' , compact('hotdeals' , 'HotDealCategory'));
    }
    
    public function hotDealCategoryStore(Request $request){
        $request->validate(['name' => 'required|min:4']);
        HotDealCategory::create(['name' => $request->name]);
        return back();
    }
    
    public function SaveHotDeals(Request $request){
        $data = [
            'name' => $request->name,
            'hot_deal_id' => json_encode($request->isCheck)
        ];
        HotDealCategory::where('id' , $request->id)->update($data);
        return back();
    }
}