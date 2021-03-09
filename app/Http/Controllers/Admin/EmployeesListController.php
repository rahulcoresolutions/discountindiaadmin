<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Redirect;
use Schema;
use App\EmployeesList;
use App\Http\Requests\CreateEmployeesListRequest;
use App\Http\Requests\UpdateEmployeesListRequest;
use Illuminate\Http\Request;



class EmployeesListController extends Controller {

	/**
	 * Display a listing of employeeslist
	 *
     * @param Request $request
     *
     * @return \Illuminate\View\View
	 */
	public function index(Request $request)
    {
        $employeeslist = EmployeesList::all();

		return view('admin.employeeslist.index', compact('employeeslist'));
	}

	/**
	 * Show the form for creating a new employeeslist
	 *
     * @return \Illuminate\View\View
	 */
	public function create()
	{
	    
	    
	    return view('admin.employeeslist.create');
	}

	/**
	 * Store a newly created employeeslist in storage.
	 *
     * @param CreateEmployeesListRequest|Request $request
	 */
	public function store(CreateEmployeesListRequest $request)
	{
	    
		EmployeesList::create($request->all());

		return redirect()->route(config('coreadmin.route').'.employeeslist.index');
	}

	/**
	 * Show the form for editing the specified employeeslist.
	 *
	 * @param  int  $id
     * @return \Illuminate\View\View
	 */
	public function edit($id)
	{
		$employeeslist = EmployeesList::find($id);
	    
	    
		return view('admin.employeeslist.edit', compact('employeeslist'));
	}

	/**
	 * Update the specified employeeslist in storage.
     * @param UpdateEmployeesListRequest|Request $request
     *
	 * @param  int  $id
	 */
	public function update($id, UpdateEmployeesListRequest $request)
	{
		$employeeslist = EmployeesList::findOrFail($id);

        

		$employeeslist->update($request->all());

		return redirect()->route(config('coreadmin.route').'.employeeslist.index');
	}

	/**
	 * Remove the specified employeeslist from storage.
	 *
	 * @param  int  $id
	 */
	public function destroy($id)
	{
		EmployeesList::destroy($id);

		return redirect()->route(config('coreadmin.route').'.employeeslist.index');
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
            EmployeesList::destroy($toDelete);
        } else {
            EmployeesList::whereNotNull('id')->delete();
        }

        return redirect()->route(config('coreadmin.route').'.employeeslist.index');
    }

}
