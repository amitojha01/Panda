<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Contact;
use App\Models\Feature;

class FeatureController extends Controller
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
        $features = Feature::where('status', 1)
                             ->get();     
        return view('frontend.features')
        ->with('features',$features);      
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
