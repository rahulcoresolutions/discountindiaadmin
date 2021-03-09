<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Subcategory;
use App\Offers;
use App\Http\Requests\CreateSubcategoryRequest;
use App\Http\Requests\UpdateSubcategoryRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\FileUploadTrait;


class SubcategoryController extends Controller {

	/**
	 * Display a listing of subcategory
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $subcategory = Subcategory::all();

		return view('admin.subcategory.index', compact('subcategory'));
	}

	/**
	 * Show the form for creating a new subcategory
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    $offers = Offers::orderBy('title' , 'ASC')->get();
	    
	    return view('admin.subcategory.create' , compact('offers'));
	}

	/**
	 * Store a newly created subcategory in storage.
	 *
     * @param CreateSubcategoryRequest|Request $request
	 */
	public function store(CreateSubcategoryRequest $request)
	{
	    
	    $request->validate([
	        'title' => 'required',
	        'offers' => 'required|array',
	        'attachment' => 'required'
	    ]);
	       $request['offers'] = json_encode($request->offers) ;
	       
	    $request = $this->saveFiles($request);
		Subcategory::create($request->all());

		return redirect()->route(config('coreadmin.route').'.subcategory.index');
	}

	/**
	 * Show the form for editing the specified subcategory.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{   
	    $offers = Offers::orderBy('title' , 'ASC')->get();
		$subcategory = Subcategory::find($id);
	    
	    
		return view('admin.subcategory.edit', compact('subcategory' , 'offers'));
	}

	/**
	 * Update the specified subcategory in storage.
     * @param UpdateSubcategoryRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateSubcategoryRequest $request)
	{
	    $request->validate([
	        'title' => 'required',
	        'offers' => 'required|array',
	    ]);
	    $request['offers'] = json_encode($request->offers);
		$subcategory = Subcategory::findOrFail($id);

        $request = $this->saveFiles($request);

		$subcategory->update($request->all());

		return redirect()->route(config('coreadmin.route').'.subcategory.index');
	}

	/**
	 * Remove the specified subcategory from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Subcategory::destroy($id);

		return redirect()->route(config('coreadmin.route').'.subcategory.index');
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
            Subcategory::destroy($toDelete);
        } else {
            Subcategory::whereNotNull('id')->delete();
        }

        return redirect()->route(config('coreadmin.route').'.subcategory.index');
    }

}
