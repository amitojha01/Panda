<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Newsletter;
use DB;

class NewsletterController extends Controller
{

    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }
    
    public function save_newsletter(Request $request)
    {   
        $email = $request->input('email');       
       $user = DB::table('newsletters')->where('email', $email)->first();
       if($user){
        return back()->with('error_1','Newsletters already subscribed !!');  
    }
    else{

     $data = $request->only(            
        'email',            
    );
     Newsletter::insert($data);
	 
	 
     return back()->with('success_1','Thank you for subscribe !!');   
 }

}

}
