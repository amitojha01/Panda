<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Banner;
use App\Models\Cms;
use App\Models\Contact;
use App\Models\Subscription;

class PricingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    
    public function index()
    { 
        $athlete_subscription = Subscription::where('status', 1)->where('type', 1)
         ->first();
         $coach_subscription = Subscription::where('status', 1)->where('type', 2)
         ->first();
        return view('frontend.pricing')
        ->with('athlete_subscription',$athlete_subscription)     
        ->with('coach_subscription',$coach_subscription);      
    }

     public function save_contact(Request $request)
    {    

     $data = $request->only(
            'first_name',
            'last_name',
            'email',
            'phone',
            'subject',
            'message'
        );  
        if(Contact::insert($data)){
            return back()->with('success','Thank you for contacting us we will reply as soon as possible!!');           

        }              

                
   }


   

    

}
