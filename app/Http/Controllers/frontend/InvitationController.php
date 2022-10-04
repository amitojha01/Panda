<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TeamingGroupUser;


class InvitationController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function acceptInvitation($token){        
        $tuser= TeamingGroupUser::where('token', $token)->first();
        if($tuser){
            $tuser->is_joined = 1; 
            $tuser->save();  
            return view('frontend.join-confirmation');
        }
    } 

    

}
