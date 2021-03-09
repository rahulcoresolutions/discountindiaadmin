<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Categories;
use App\Http\Requests\CreateCategoriesRequest;
use App\Http\Requests\UpdateCategoriesRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\FileUploadTrait;


class CategoriesController extends Controller {

	/**
	 * Display a listing of categories
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $categories = Categories::orderBy('order' , 'ASC')->get();

		return view('admin.categories.index', compact('categories'));
	}

	/**
	 * Show the form for creating a new categories
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    
	    
	    return view('admin.categories.create');
	}

	/**
	 * Store a newly created categories in storage.
	 *
     * @param CreateCategoriesRequest|Request $request
	 */
	public function store(CreateCategoriesRequest $request)
	{
	    $request = $this->saveFiles($request);
		Categories::create($request->all());

		return redirect()->route(config('coreadmin.route').'.categories.index');
	}

	/**
	 * Show the form for editing the specified categories.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$categories = Categories::find($id);
	    
	    
		return view('admin.categories.edit', compact('categories'));
	}

	/**
	 * Update the specified categories in storage.
     * @param UpdateCategoriesRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateCategoriesRequest $request)
	{
		$categories = Categories::findOrFail($id);

        $request = $this->saveFiles($request);

		$categories->update($request->all());

		return redirect()->route(config('coreadmin.route').'.categories.index');
	}

	/**
	 * Remove the specified categories from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Categories::destroy($id);

		return redirect()->route(config('coreadmin.route').'.categories.index');
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
            Categories::destroy($toDelete);
        } else {
            Categories::whereNotNull('id')->delete();
        }

        return redirect()->route(config('coreadmin.route').'.categories.index');
    }

}
