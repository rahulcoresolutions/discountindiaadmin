<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Hash;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->redirectTo = config('coreadmin.route');
        $this->middleware('guest', ['except' => 'logout']);
    }
    public function login(Request $request)
    {
        $user = User::where('email' , $request->email)->first();
        if( $user != null ){
            // if( $user->role_id == 1 ){
                if( Hash::check( $request->password , $user->password ) ){
                    Auth::loginUsingId($user->id);
                    return redirect()->route('dashboard');
                }else{
                    Session::flash('err' , "Wrong username and password OR you are not allowed to Login this pannel");
                    return back();
                }   
            // }
        }else{
            Session::flash('err' , "Wrong username and password OR you are not allowed to Login this pannel");
            return back();
        }
        
    }

}