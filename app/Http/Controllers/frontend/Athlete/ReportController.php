<?php

namespace App\Http\Controllers\Frontend\Athlete;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Report;
use App\Mail\ReportMail;
use Illuminate\Support\Facades\Mail;
use Session;
use DB;
use DateTime;


class ReportController extends Controller
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


    public function index()
    { 
        return view('frontend.athlete.report.index');      
    }

   public function saveReport(Request $request)
    {      
         
        $userId= Auth()->user()->id;
        
        $request->validate([
            'subject' => 'required',
            'mobile' => 'required',
            'message' => 'required',
        ]);
        try{
        
         $data = $request->only(['subject', 'mobile', 'message']);
         $data['user_id'] = $userId;
        $email= "customersupport@parcsports.com";
       //  $email= "ameetojha01@gmail.com";
        $email_data= array(
            'name' => Auth()->user()->username,
            'email' => Auth()->user()->email,
            'phone_no' =>$request->input('mobile'),
            'message' =>$request->input('message'),

        );
       
        Mail::to($email)->send(new ReportMail($email_data));
            if(Report::insert($data)){
                return back()->with('success','Thank you for contacting us we will reply as soon as possible!!');  
            } 
        }
        catch(\Exception $e)
        {
            return back()->with('error','Unable to save data');
        }            
    }

    
     
}
