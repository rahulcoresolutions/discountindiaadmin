<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\PaidVouchers;
use App\Http\Requests\CreateVouchersRequest;
use App\Http\Requests\UpdateVouchersRequest;
use Illuminate\Http\Request;
use App\Categories;
use App\Plans;
use App\Offers;
use App\ShareVoucher;
use App\User;
use Illuminate\Database\Schema\Blueprint;
use App\PlanVoucherMap;
use Auth;
use App\Vouchers;
use Session;

class PaidVoucherController extends Controller {

	/**
	 * Display a listing of vouchers
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $listVouchers = Vouchers::with(['Offer' , 'vocuherDetails'])->get();
    	if(Auth::user()){
    		if( Auth::user()->role_id == 1){
		        $vouchers = PaidVouchers::orderBy('id' , 'DESC')->with([ 'Offer' ])->get();
    		}else{
    			$offerId = Auth::user()->offerId;
    			$vouchers = PaidVouchers::orderBy('id' , 'DESC')->where('voucher_of' , $offerId)->with([ 'Offer' ])->get();
    		}
    	}

		return view('admin.paidVouchers.index', compact('vouchers' , 'listVouchers'));
	}

	public function indexRedirection()
    {
		$userId = Auth::user()->offerId;
        $vouchers = PaidVouchers::orderBy('id' , 'DESC')->where('voucher_of' , $userId)->with([ 'Offer' ])->get();
		return view('admin.paidVouchers.index', compact('vouchers'));
	}

	/**
	 * Show the form for creating a new vouchers
	 *
     * @return \Illuminate\View\View
	 */
	public function createPaidVoucher()
	{
	    $Categories = Categories::get();
	    $plans = Plans::get();
	    $offers = Offers::where('category' , 1)->get();

	    if( Auth::user()->role_id == 1){
		    $vouchers = Vouchers::with(['Offer'])->get();
		}else{
			$userId = Auth::user()->offerId;
		    $vouchers = Vouchers::where('voucher_of' , $userId)->with(['Offer'])->get();
	        // $vouchers = PaidVouchers::orderBy('id' , 'DESC')->with([ 'Offer' ])->get();
		}
	    return view('admin.paidVouchers.create' , compact('Categories', 'plans','offers','vouchers'));
	}

	public function getCatOffers(Request $request)
	{
		$catId = $request->catId;
		$Offers = Offers::select('title' , 'id')->where('category' , $catId)->get();
		return $Offers;
	}

	/**
	 * Store a newly created vouchers in storage.
	 *
     * @param CreateVouchersRequest|Request $request
	 */
	public function store(Request $request)
	{			
		$userDetail = Auth::user();
		$user = User::whereId($userDetail->id)->with('offers')->first();

		if($request->file('bannerImage')){
			$file =	$request->file('bannerImage');
			$fileName = $file->getCLientOriginalName();
			$fileExt = $file->getCLientOriginalExtension();
			$fileSize = $file->getSize();

			if( $fileSize <= 1048576 ){
				$destination = 'voucher/images/';
				$file->move($destination , $fileName);
			}
		}else{
			$fileName = null;
		}
		if( $user->offers != null ){
			$category = $user->offers->category;
		}else{
			$category = 0;
		}

		$Offers 			= $request->offerId;
		$voucher_template 	= $request->voucher_template;
		$title 				= $request->title;
		$valid_date 		= $request->valid_date;
		$terms_condition 	= $request->terms_condition;
		$customer_price 	= $request->customer_price;
		$hotel_price 		= $request->hotel_price;
		$barcode 			= $request->barcode;
		$discount 			= $request->discount;
		$voucher_of 		= $request->voucher_of;

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
			$paidvouchers = 'PVC_'.$paidvouchers;

		}else{
			$paidvouchers = "PVC_000001";
		}

		$data = [
			'title' 			=> $title,
			'valid_date' 		=> $valid_date,
			'terms_condition' 	=> $terms_condition,
			'barcode' 			=> $barcode,
			'discount' 			=> $discount,
			'voucher_of' 		=> $voucher_of,
			'voucher_unique_id' => $paidvouchers,
			'voucher_template' 	=> $voucher_template, 
			'custom_template' 	=> 0,
			'customer_price' 	=> $customer_price,
			'hotel_price' 		=> $hotel_price,
			'fileName' 			=> $fileName,
			'discount_india_price' => ($customer_price - $hotel_price),
		];

		$createVoucher = PaidVouchers::create($data);
		return back();
		return $this->indexRedirection();
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
    public function shareVoucher(Request $request)
    {
    	$request->validate([
			'voucherId' => 'required',
			'userId' => 'required',
			'amount' => 'required',
			'expiredDate' => 'required'
    	]);
    	
    	ShareVoucher::create([
    		'voucherId' => $request->voucherId,
	        'userId' => $request->userId,
	        'status' => 1,
	        'amount' => $request->amount,
	        'expiredDate' => $request->expiredDate
    	]);
    	return back();
    }
    public function listShareVoucher()
    {
    	$vouchers = ShareVoucher::with(['user','voucherDetails'])->orderBy('id', 'DESC')->get();
    	return view('admin.sharedVoucher.index' , compact('vouchers'));
    }
    public function deletePaidVoucher($id)
    {
    	$voucher = PaidVouchers::whereId($id)->delete();
    	Session::flash('message' , "Voucher delete successfully");
    	return back();
    }
    public function getPaidVoucherDetails($id)
    {
    	$vouchers = Vouchers::with(['Offer'])->get();
    	$paidvouchers = PaidVouchers::whereId($id)->with(['Offer'])->first();
    	$Categories = Categories::get();
	    $plans = Plans::get();
	    $offers = Offers::where('category' , 1)->get();

    	return view( 'admin.paidVouchers.edit', compact('vouchers','plans','offers','paidvouchers'));
    }

    public function updatetPaidVoucherDetails(Request $request)
    {
    	if( $request->has('voucherType') ){

    		if( $request->voucherType == 'uploadVoucher' ) {

    			if($request->file('bannerImage')){
					$file =	$request->file('bannerImage');
					$fileName = $file->getCLientOriginalName();
					$fileExt = $file->getCLientOriginalExtension();
					$fileSize = $file->getSize();

					if( $fileSize <= 1048576 ){
						$destination = 'voucher/images/';
						$file->move($destination , $fileName);
					}
					$Offers 			= $request->offerId;
					$voucher_template 	= $request->voucher_template;
					$title 				= $request->title;
					$valid_date 		= $request->valid_date;
					$terms_condition 	= $request->terms_condition;
					$customer_price 	= $request->customer_price;
					$hotel_price 		= $request->hotel_price;
					$barcode 			= $request->barcode;
					$discount 			= $request->discount;
					$voucher_of 		= $request->voucher_of;

					$data = [
						'title' 			=> $title,
						'valid_date' 		=> $valid_date,
						'terms_condition' 	=> $terms_condition,
						'barcode' 			=> $barcode,
						'discount' 			=> $discount,
						'voucher_of' 		=> $voucher_of,
						'voucher_template' 	=> 0, 
						'custom_template' 	=> 1,
						'customer_price' 	=> $customer_price,
						'hotel_price' 		=> $hotel_price,
						'fileName' 			=> $fileName,
						'discount_india_price' => ($customer_price - $hotel_price),
					];

					$createVoucher = PaidVouchers::whereId($request->selectedVoucherId)->update($data);
				}else{
					$voucher_template 	= $request->voucher_template;
					$title 				= $request->title;
					$valid_date 		= $request->valid_date;
					$terms_condition 	= $request->terms_condition;
					$customer_price 	= $request->customer_price;
					$hotel_price 		= $request->hotel_price;
					$barcode 			= $request->barcode;
					$discount 			= $request->discount;
					$voucher_of 		= $request->voucher_of;

	    			$data = [
							'title' 			=> $title,
							'valid_date' 		=> $valid_date,
							'terms_condition' 	=> $terms_condition,
							'barcode' 			=> $barcode,
							'discount' 			=> $discount,
							'voucher_of' 		=> $voucher_of,
							'voucher_template' 	=> $voucher_template, 
							'custom_template' 	=> 0,
							'customer_price' 	=> $customer_price,
							'hotel_price' 		=> $hotel_price,
							'discount_india_price' => ($customer_price - $hotel_price),
						];

						$createVoucher = PaidVouchers::whereId($request->selectedVoucherId)->update($data);
				}

    		}else{


    			if($request->file('bannerImage')){
					$file =	$request->file('bannerImage');
					$fileName = $file->getCLientOriginalName();
					$fileExt = $file->getCLientOriginalExtension();
					$fileSize = $file->getSize();

					if( $fileSize <= 1048576 ){
						$destination = 'voucher/images/';
						$file->move($destination , $fileName);
					}
					$Offers 			= $request->offerId;
					$voucher_template 	= $request->voucher_template;
					$title 				= $request->title;
					$valid_date 		= $request->valid_date;
					$terms_condition 	= $request->terms_condition;
					$customer_price 	= $request->customer_price;
					$hotel_price 		= $request->hotel_price;
					$barcode 			= $request->barcode;
					$discount 			= $request->discount;
					$voucher_of 		= $request->voucher_of;

					$data = [
						'title' 			=> $title,
						'valid_date' 		=> $valid_date,
						'terms_condition' 	=> $terms_condition,
						'barcode' 			=> $barcode,
						'discount' 			=> $discount,
						'voucher_of' 		=> $voucher_of,
						'voucher_template' 	=> 0, 
						'custom_template' 	=> 1,
						'customer_price' 	=> $customer_price,
						'hotel_price' 		=> $hotel_price,
						'fileName' 			=> $fileName,
						'discount_india_price' => ($customer_price - $hotel_price),
					];

					$createVoucher = PaidVouchers::whereId($request->selectedVoucherId)->update($data);
				}else{
					$voucher_template 	= $request->voucher_template;
					$title 				= $request->title;
					$valid_date 		= $request->valid_date;
					$terms_condition 	= $request->terms_condition;
					$customer_price 	= $request->customer_price;
					$hotel_price 		= $request->hotel_price;
					$barcode 			= $request->barcode;
					$discount 			= $request->discount;
					$voucher_of 		= $request->voucher_of;

	    			$data = [
							'title' 			=> $title,
							'valid_date' 		=> $valid_date,
							'terms_condition' 	=> $terms_condition,
							'barcode' 			=> $barcode,
							'discount' 			=> $discount,
							'voucher_of' 		=> $voucher_of,
							'voucher_template' 	=> $voucher_template, 
							'custom_template' 	=> 0,
							'customer_price' 	=> $customer_price,
							'hotel_price' 		=> $hotel_price,
							'discount_india_price' => ($customer_price - $hotel_price),
						];

						$createVoucher = PaidVouchers::whereId($request->selectedVoucherId)->update($data);
				}
    		}
    	}

    	return back();








		$Offers 			= $request->offerId;
		$voucher_template 	= $request->voucher_template;
		$title 				= $request->title;
		$valid_date 		= $request->valid_date;
		$terms_condition 	= $request->terms_condition;
		$customer_price 	= $request->customer_price;
		$hotel_price 		= $request->hotel_price;
		$barcode 			= $request->barcode;
		$discount 			= $request->discount;
		$voucher_of 		= $request->voucher_of;

    	$data = [
			'title' 			=> $title,
			'valid_date' 		=> $valid_date,
			'terms_condition' 	=> $terms_condition,
			'barcode' 			=> $barcode,
			'discount' 			=> $discount,
			'voucher_of' 		=> $voucher_of,
			'voucher_template' 	=> $voucher_template, 
			'custom_template' 	=> 0,
			'customer_price' 	=> $customer_price,
			'hotel_price' 		=> $hotel_price,
			'fileName' 			=> $fileName,
			'discount_india_price' => ($customer_price - $hotel_price),
		];

		$createVoucher = PaidVouchers::create($data);

		return back();

    	$userDetail = Auth::user();
		$user = User::whereId($userDetail->id)->with('offers')->first();

		if($request->file('bannerImage')){
			$file =	$request->file('bannerImage');
			$fileName = $file->getCLientOriginalName();
			$fileExt = $file->getCLientOriginalExtension();
			$fileSize = $file->getSize();

			if( $fileSize <= 1048576 ){
				$destination = 'voucher/images/';
				$file->move($destination , $fileName);
			}
		}else{
			$fileName = null;
		}
		if( $user->offers != null ){
			$category = $user->offers->category;
		}else{
			$category = 0;
		}

		$Offers 			= $request->offerId;
		$voucher_template 	= $request->voucher_template;
		$title 				= $request->title;
		$valid_date 		= $request->valid_date;
		$terms_condition 	= $request->terms_condition;
		$customer_price 	= $request->customer_price;
		$hotel_price 		= $request->hotel_price;
		$barcode 			= $request->barcode;
		$discount 			= $request->discount;
		$voucher_of 		= $request->voucher_of;

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
			$paidvouchers = 'PVC_'.$paidvouchers;

		}else{
			$paidvouchers = "PVC_000001";
		}

		$data = [
			'title' 			=> $title,
			'valid_date' 		=> $valid_date,
			'terms_condition' 	=> $terms_condition,
			'barcode' 			=> $barcode,
			'discount' 			=> $discount,
			'voucher_of' 		=> $voucher_of,
			'voucher_unique_id' => $paidvouchers,
			'voucher_template' 	=> $voucher_template, 
			'custom_template' 	=> 0,
			'customer_price' 	=> $customer_price,
			'hotel_price' 		=> $hotel_price,
			'fileName' 			=> $fileName,
			'discount_india_price' => ($customer_price - $hotel_price),
		];

		$createVoucher = PaidVouchers::create($data);
		return back();
		return $this->indexRedirection();
    }
}