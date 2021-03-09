<?php
namespace CoreSolutions\CoreAdmin\Controllers;

use App\Http\Controllers\Controller;

class CoreAdminController extends Controller
{
    /**
     * Show QuickAdmin dashboard page
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.dashboard');
    }
}