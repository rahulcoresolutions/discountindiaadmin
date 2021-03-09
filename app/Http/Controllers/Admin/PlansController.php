<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Plans;
use App\Http\Requests\CreatePlansRequest;
use App\Http\Requests\UpdatePlansRequest;
use Illuminate\Http\Request;



class PlansController extends Controller {

	/**
	 * Display a listing of plans
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $plans = Plans::all();

		return view('admin.plans.index', compact('plans'));
	}

	/**
	 * Show the form for creating a new plans
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    
	    
	    return view('admin.plans.create');
	}

	/**
	 * Store a newly created plans in storage.
	 *
     * @param CreatePlansRequest|Request $request
	 */
	public function store(CreatePlansRequest $request)
	{
		if($request->file('imagename')){
			$file =	$request->file('imagename');
			$fileName = $file->getCLientOriginalName();
			$fileExt = $file->getCLientOriginalExtension();
			$fileSize = $file->getSize();

			$destination = 'plan/images/';
			$file->move($destination , $fileName);
			$request->image = $fileName;
		}
		
	    
		Plans::create($request->all());

		return redirect()->route(config('coreadmin.route').'.plans.index');
	}

	/**
	 * Show the form for editing the specified plans.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$plans = Plans::find($id);
	    
	    
		return view('admin.plans.edit', compact('plans'));
	}

	/**
	 * Update the specified plans in storage.
     * @param UpdatePlansRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdatePlansRequest $request)
	{
		if($request->file('imagename')){
			$file =	$request->file('imagename');
			$fileName = $file->getCLientOriginalName();
			$fileExt = $file->getCLientOriginalExtension();
			$fileSize = $file->getSize();

			$destination = 'plan/images/';
			$file->move($destination , $fileName);
			$request->merge(['image' => $fileName]);
		}
		

		$plans = Plans::findOrFail($id);
		$plans->update($request->all());

		return redirect()->route(config('coreadmin.route').'.plans.index');
	}

	/**
	 * Remove the specified plans from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Plans::destroy($id);

		return redirect()->route(config('coreadmin.route').'.plans.index');
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
            Plans::destroy($toDelete);
        } else {
            Plans::whereNotNull('id')->delete();
        }

        return redirect()->route(config('coreadmin.route').'.plans.index');
    }

}
