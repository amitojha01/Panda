<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;

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

    //use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }
    public function index()
    {
        return view('frontend.login.index');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|min:8',
        ]);
        $email= $request->input('email');
        $password= $request->input('password');
        
        //if (Auth::attempt($credentials)) {
         if (Auth::attempt(['email' => $email, 'password' => $password])){
            //check role ID to access dashboard
            if(Auth()->user()->role_id == 1){
                return redirect()->intended('athlete/dashboard')
                        ->withSuccess('Signed in');
            }
            if(Auth()->user()->role_id == 2){
                return redirect()->intended('coach/dashboard')
                        ->withSuccess('Signed in');
            }
        }elseif(Auth::attempt(['username' => $email, 'password' => $password])){
            if(Auth()->user()->role_id == 1){
                return redirect()->intended('athlete/dashboard')
                        ->withSuccess('Signed in');
            }
            if(Auth()->user()->role_id == 2){
                return redirect()->intended('coach/dashboard')
                        ->withSuccess('Signed in');
            }
        }else{
            return redirect("/login")->with('error','Invalid credentials');

        }
  
        
    }
}
