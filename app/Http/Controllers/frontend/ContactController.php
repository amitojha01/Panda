<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Banner;
use App\Models\Cms;
use App\Models\Contact;
use App\Models\Setting;
use App\Mail\ContactUsMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
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
        // $banner = Banner::where('page_id', 3)
        //                     ->with('page')
                            // ->first(); 

        // $content = Cms::where('page_id', 3)
        //                      ->get();

        // return view('frontend.contact',['banners' => $banner, 'cms' => $content]);  
        $setting = Setting::all(); 
        // dd($setting);
        return view('frontend.contact')
        ->with('setting', $setting);     
    }

     public function save_contact(Request $request)
    {      
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone_no' => 'required',
            'message' => 'required|max:1000',
        ]);
        try{
         $data = $request->only(
                'name',
                'email',
                'phone_no',
                'message'
            );  
        $email_data= array(
            'name' =>$request->input('name'),
            'email' =>$request->input('email'),
            'phone_no' =>$request->input('phone_no'),
            'message' =>$request->input('message'),

        );
        $email=  getSettings('Email');
        Mail::to($email)->send(new ContactUsMail($email_data));
            if(Contact::insert($data)){
                return back()->with('success','Thank you for contacting us we will reply as soon as possible!!');  
            } 
        }
        catch(\Exception $e)
        {
            return back()->with('error','Unable to save data');
        }            
    }
    
    

   

    

}
