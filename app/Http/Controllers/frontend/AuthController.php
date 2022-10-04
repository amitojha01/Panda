<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use Hash;
use Session;
use Cookie;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Http\RedirectResponse;
use App\Models\User;
use DB;
use App\Mail\ForgotPasswordMail;


class AuthController extends Controller
{

    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }
     public function checkEmail(Request $request)
    {
        $result = DB::table('users')->where('email', $request->email)->count();          
        return response()->json($result);
    }

    public function forgotPassword(Request $request)
    {
        // if(Auth::check() && Auth::user()->role_id == 1 ){
        //     //return redirect('athlete/dashboard');
        //     return view('frontend.login.forgot-password');
        // }
        return view('frontend.login.forgot-password');
    }
    /*
        ** OTP validate & reset password
    */
    public function getResetPassword()
    {
        // if(Auth::check() && Auth::user()->role_id == 1 ){
        //     //return redirect('athlete/dashboard');
        //     return view('frontend.login.forgot-password');
        // }
        return view('frontend.login.change-password');
    }

    public function resetPassword(Request $request){
        $request->validate([
            'email' => 'required',
        ]);

        $email = $request->email;

        $email_data = $request->only('email');
        Mail::to($email_data['email'])->send(new ForgotPasswordMail($email_data));

        return back()->with('success', 'Email sent successfully!!');

    }

    public function changePassword($email){

        return view('frontend.login.change-password')->with('email', $email);
    }

    public function updatePassword(Request $request)
    {  

        $email= $request->email;
        $decodeemail= base64_decode($email);

        $user = User::where('email',$decodeemail)->first();    

        $new_pwd = $request->input('new_password');
        $confirm_pwd = $request->input('confirm_password');
        $user->password = Hash::make($new_pwd);        
        $data = $request->all();

        if($new_pwd!= $confirm_pwd){
            return back()->with('error','Password not match!!');
        }
        else{  
           $user->save();  
           return redirect('/login')->with('success','Password Updated successfully!!'); 
     //return back()->with('success','Password Updated successfully!!');

       }
   }

}
