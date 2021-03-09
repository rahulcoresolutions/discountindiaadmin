<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\Topslider;
use App\Http\Requests\CreateTopsliderRequest;
use App\Http\Requests\UpdateTopsliderRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\FileUploadTrait;


class TopsliderController extends Controller {

	/**
	 * Display a listing of topslider
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $topslider = Topslider::all();

		return view('admin.topslider.index', compact('topslider'));
	}

	/**
	 * Show the form for creating a new topslider
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    
	    
	    return view('admin.topslider.create');
	}

	/**
	 * Store a newly created topslider in storage.
	 *
     * @param CreateTopsliderRequest|Request $request
	 */
	public function store(CreateTopsliderRequest $request)
	{
	    $request = $this->saveFiles($request);
		Topslider::create($request->all());

		return redirect()->route(config('coreadmin.route').'.topslider.index');
	}

	/**
	 * Show the form for editing the specified topslider.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$topslider = Topslider::find($id);
	    
	    
		return view('admin.topslider.edit', compact('topslider'));
	}

	/**
	 * Update the specified topslider in storage.
     * @param UpdateTopsliderRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateTopsliderRequest $request)
	{
		$topslider = Topslider::findOrFail($id);

        $request = $this->saveFiles($request);

		$topslider->update($request->all());

		return redirect()->route(config('coreadmin.route').'.topslider.index');
	}

	/**
	 * Remove the specified topslider from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		Topslider::destroy($id);

		return redirect()->route(config('coreadmin.route').'.topslider.index');
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
            Topslider::destroy($toDelete);
        } else {
            Topslider::whereNotNull('id')->delete();
        }

        return redirect()->route(config('coreadmin.route').'.topslider.index');
    }

}
