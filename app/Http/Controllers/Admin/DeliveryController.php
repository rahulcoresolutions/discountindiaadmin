<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Delivery;
use App\Http\Requests\CreateDeliveryRequest;
use App\Http\Requests\UpdateDeliveryRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Cities;

class DeliveryController extends Controller {

	/**
	 * Display a listing of delivery
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $delivery = Delivery::all();
        $cities = Cities::all()->pluck( 'city' , 'id' )->toArray();
		return view('admin.delivery.index', compact('delivery', 'cities' ));
	}

	/**
	 * Show the form for creating a new delivery
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
        $cities = Cities::all();
	    return view('admin.delivery.create' , compact('cities'));
	}

	/**
	 * Store a newly created delivery in storage.
	 *
     * @param CreateDeliveryRequest|Request $request
	 */
	public function store(CreateDeliveryRequest $request)
	{
	    $request = $this->saveFiles($request);
		Delivery::create($request->all());

		return redirect()->route(config('coreadmin.route').'.delivery.index');
	}

	/**
	 * Show the form for editing the specified delivery.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$delivery = Delivery::find($id);
        $cities = Cities::all();
		return view('admin.delivery.edit', compact('delivery' , 'cities'));
	}

	/**
	 * Update the specified delivery in storage.
     * @param UpdateDeliveryRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateDeliveryRequest $request)
	{
		$delivery = Delivery::findOrFail($id);

        $request = $this->saveFiles($request);

		$delivery->update($request->all());

		return redirect()->route(config('coreadmin.route').'.delivery.index');
	}

	/**
	 * Remove the specified delivery from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Delivery::destroy($id);

		return redirect()->route(config('coreadmin.route').'.delivery.index');
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
            Delivery::destroy($toDelete);
        } else {
            Delivery::whereNotNull('id')->delete();
        }

        return redirect()->route(config('coreadmin.route').'.delivery.index');
    }

}
