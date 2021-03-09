<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\SubscribePlan;
use App\Http\Requests\CreateSubscribePlanRequest;
use App\Http\Requests\UpdateSubscribePlanRequest;
use Illuminate\Http\Request;
use App\Plans;
use Carbon\Carbon;


class SubscribePlanController extends Controller {

	/**
	 * Display a listing of subscribeplan
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $subscribeplan = SubscribePlan::with('plan')->get();

		return view('admin.subscribeplan.index', compact('subscribeplan'));
	}

	/**
	 * Show the form for creating a new subscribeplan
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    $plans = Plans::pluck('title','id');
	    return view('admin.subscribeplan.create' , compact('plans'));
	}

	/**
	 * Store a newly created subscribeplan in storage.
	 *
     * @param CreateSubscribePlanRequest|Request $request
	 */
	public function store(CreateSubscribePlanRequest $request)
	{
		SubscribePlan::create($request->all());
		
		return redirect()->route(config('coreadmin.route').'.subscribeplan.index');
	}

	/**
	 * Show the form for editing the specified subscribeplan.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$subscribeplan = SubscribePlan::find($id);
	    
	    
		return view('admin.subscribeplan.edit', compact('subscribeplan'));
	}

	/**
	 * Update the specified subscribeplan in storage.
     * @param UpdateSubscribePlanRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateSubscribePlanRequest $request)
	{
		$subscribeplan = SubscribePlan::findOrFail($id);

        

		$subscribeplan->update($request->all());

		return redirect()->route(config('coreadmin.route').'.subscribeplan.index');
	}

	/**
	 * Remove the specified subscribeplan from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		SubscribePlan::destroy($id);

		return redirect()->route(config('coreadmin.route').'.subscribeplan.index');
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
            SubscribePlan::destroy($toDelete);
        } else {
            SubscribePlan::whereNotNull('id')->delete();
        }

        return redirect()->route(config('coreadmin.route').'.subscribeplan.index');
    }

}
