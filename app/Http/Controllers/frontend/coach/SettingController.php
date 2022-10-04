<?php

namespace App\Http\Controllers\Frontend\Coach;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');

    }

    public function changePassword()
    {
        $user_id= Auth()->user()->id;
        
        $user = User::where('id', $user_id)
        ->first();

        return view('frontend.coach.setting.change-password')
        ->with('user', $user);                       
    }

    public function updatePassword(Request $request, $id){

        $user = User::find( $id ); 
        $new_pwd = $request->input('new_password');
        $confirm_pwd = $request->input('confirm_password');
        $user->password = Hash::make($new_pwd);        
        $data = $request->all();

        if($new_pwd!= $confirm_pwd){
            return back()->with('error','Password not match!!');
        }
        else{  
            $user->save();   
            return back()->with('success','Password Updated successfully!!');
        }
    }

}
