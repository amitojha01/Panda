<?php

namespace App\Http\Controllers\Frontend\Athlete;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sport;
use App\Models\College;
use App\Models\EmailCoach;
use App\Models\CoachEmail;
use DB;
use App\Mail\CoachMail;

use Illuminate\Support\Facades\Mail;


class EmailController extends Controller
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
        $user_id= Auth()->user()->id; 
        $sport = EmailCoach::groupBy('sport')->get();
        $college_list= EmailCoach::groupBy('school')->get(); 
        return view('frontend.athlete.email.index')
        ->with('sport',  $sport)
        ->with('college_list',  $college_list);

    }



    public function searchCoach(Request $request)
    {

       $sports = $request->input('sport');
       $school= $request->input('school');
       $gender= $request->input('gender');
       $coachName = $request->input('coachName');
      
       if($coachName!=""){         
         $result = EmailCoach::where('name','LIKE','%'.$coachName.'%')->orderBy('name', 'ASC')->get();
         
       }else{
        $result = EmailCoach::whereIn('sport', $sports)->where('school', $school)->where('gender', $gender)->orderBy('name', 'ASC')->get();
       }      

       return view('frontend.athlete.email.coach-list')
       ->with('result', $result);
   }

   public function emailcoach(Request $request)
   {

       $coachEmailone = $request->input('coachEmailone');
       $coachEmailtwo= $request->input('coachEmailtwo');

       return view('frontend.athlete.email.email-coach')
       ->with('coachEmailone', $coachEmailone)
       ->with('coachEmailtwo', $coachEmailtwo);
   }

   /*******sendgrid email***********/


   public function sendMail(Request $request){
    $email= $request->input('email');
    $subject= $request->input('subject');
    $message= $request->input('message');
    $profile_link= $request->input('profile_link');
    $from_email= $request->input('from_email');
    $athlete_name= $request->input('athlete_name');

    $sender_id= Auth()->user()->id;

    $emailList = implode(', ', $email);    

     $emailData= array(
            'sender_id' => $sender_id,
            'recipient_email' => $emailList, 
            'from_email' => $from_email,
            'subject' => $subject, 
            'message' => $message,
            'profile_link' =>  $profile_link,          
           
        );
     CoachEmail::insert($emailData); 
     

    for($i=0; $i<count($email); $i++){
 
     $email_data= array(
      'subject' => $subject,
      'message' => $message,
      'profile_link' => $profile_link,
      'from_email' => $from_email,
      'athlete_name' => $athlete_name
    );

    Mail::to($email[$i])->send(new CoachMail($email_data)); 

   }
 Mail::to($from_email)->send(new CoachMail($email_data)); 

       
    // return view('emails.coach-mail')
  // ->with('data', $email_data); 



   return redirect('/athlete/email-coach')->with('success','Email Sent Successfully!!'); 
   

 }

 public function sentList(){
   $sent_list = CoachEmail::where('sender_id', Auth()->user()->id)->get();
    return view('frontend.athlete.email.sent-list')
       ->with('sent_list', $sent_list);
 }

   

}
