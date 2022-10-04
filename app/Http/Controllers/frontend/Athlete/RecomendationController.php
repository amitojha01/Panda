<?php

namespace App\Http\Controllers\Frontend\Athlete;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Recommendation;
use App\Mail\RequestMail;
use App\Mail\LinkMail;
use App\Mail\ProfileLinkMail;
use Illuminate\Support\Facades\Mail;
use DB;
use DateTime;


class RecomendationController extends Controller
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
        $recommended_coach_list =DB::table('recommendation')
        ->leftjoin('users','recommendation.receiver_id', '=', 'users.id')

        ->leftJoin('user_address','users.id', '=', 'user_address.user_id')

        ->leftJoin('countries','countries.id', '=', 'user_address.country_id')

         ->leftJoin('coach_informations','coach_informations.user_id', '=', 'users.id')

         ->select('recommendation.id as recommend_id','recommendation.recommendation', 'recommendation.updated_recommendation', 'recommendation.recommend_status','recommendation.created_at','recommendation.status','recommendation.order_no','recommendation.reply_msg','users.username','users.profile_image',
            'countries.name as country_name','coach_informations.coaching_level')
         ->whereIn('recommendation.recommend_status', [1,3,4])
          //->where('recommendation.status', 0)
         ->where('recommendation.sender_id', $user_id)
         //->groupBy('users.id')
        ->get();          
                
        return view('frontend.athlete.recomendation.index')
       ->with('recommended_coach_list', $recommended_coach_list);        
    }

    
    public function newRecomendation(){
        return view('frontend.athlete.recomendation.coach-recommendation-request');

    }

    public function searchByUserId(Request $request)
    {

        $result =DB::table('users')
        ->leftJoin('user_address','users.id', '=', 'user_address.user_id')

        ->leftJoin('countries','countries.id', '=', 'user_address.country_id')

         ->leftJoin('coach_informations','coach_informations.user_id', '=', 'users.id')

        ->select('users.id','users.username','users.email','users.profile_image','users.role_id','countries.name as country_name','coach_informations.coaching_level', 'coach_informations.serve_as_reference' )
        ->where('users.username','LIKE', '%' . $request->text . '%')
        
        ->where('users.status', '!=', 0)   
        ->where('users.id', '!=', Auth()->user()->id)     
        ->whereNotIn('users.role_id', ['0','1'])
        ->get();
        
        return response()->json($result);
    }

    public function searchByEmail(Request $request)
    {
       
        $result =DB::table('users')
        ->leftJoin('user_address','users.id', '=', 'user_address.user_id')

        ->leftJoin('countries','countries.id', '=', 'user_address.country_id')

         ->leftJoin('coach_informations','coach_informations.user_id', '=', 'users.id')

        ->select('users.id','users.username','users.email','users.profile_image','users.role_id','countries.name as country_name','coach_informations.coaching_level' )
        ->where('users.email','LIKE', '%' . $request->text . '%')
        
        ->where('users.status', '!=', 0)   
        ->where('users.id', '!=', Auth()->user()->id)     
        ->whereNotIn('users.role_id', ['0','1'])
        ->get();
        
        return response()->json($result);
    }

    public function acceptRecomendation(Request $request){
        $recommend_id= $request->recommend_id;
         $detail = Recommendation::where('id', $recommend_id)       
        ->first(); 
        $updated_recmd= $detail->updated_recommendation;
        
        Recommendation::where('id', $recommend_id)->update(['recommendation'=>$updated_recmd, 'recommend_status'=>3]);

      
        return back()->with('success', 'Recommendation Accepted!!');
        
    }


     public function rejectRecommend($id=""){        
        $recommendId=$id;  

       if(Recommendation::where('id', $recommendId)->update(['recommend_status'=>4])){            
        
        return response()->json([
            'success' => true,
            'data'=> 'Recommend',
            'message'=>'Recommendation rejected!!'
        ], 200);
        }else{
            return back()->with('error', 'Oops!! Something went wrong');
        }
    }

    /*public function sendRequest(Request $request){
        //$email= $request->email;
        $receiver_id= $request->receiver_id;
        $email= $request->receiver_email;
        echo $email;exit;

        $user_id= Auth()->user()->id;
        $senderDetail = User::where('id', $user_id)       
        ->first(); 

        $token = substr(str_shuffle("abcdefghijklmnopqrstABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);

        $requestData= array(
            'sender_id' => $user_id, 
            'receiver_id' => $receiver_id,
            'token' => $token,           
            'status' => 0,                       
        );

        $email_data= array(
            'creator_name' =>$senderDetail->username,
            'creator_email' => $senderDetail->email, 
            'token' => $token,           
        );

        Mail::to($email)->send(new RequestMail($email_data));
        
         if(Recommendation::insert($requestData)){
             return response()->json([
            'status' => true,
            'message' => 'Request Send successfully',
        ]);
        }else{
              return response()->json([
            'status' => true,
            'message' => 'Something went wrong',
        ]);
        }       
       
    }*/
    public function sendRequest(Request $request){
        $receiver_id= $request->receiver_id;
        $email= $request->receiver_email;
        $request_purpose= $request->request_purpose;             
        $user_id= Auth()->user()->id;
        $senderDetail = User::where('id', $user_id)       
        ->first(); 

        $token = substr(str_shuffle("abcdefghijklmnopqrstABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);

        $requestData= array(
            'sender_id' => $user_id, 
            'receiver_id' => $receiver_id,
            'token' => $token, 
            'request_purpose'=>$request_purpose,          
            'status' => 0,                       
        );

       /* $email_data= array(
            'creator_name' =>$senderDetail->username,
            'creator_email' => $senderDetail->email, 
            'token' => $token,           
        );*/

       /* Mail::to($email)->send(new RequestMail($email_data));*/
        
         if(Recommendation::insert($requestData)){
             return redirect('/athlete/new-recomendation')->with('success','Request Sent Successfully');
        }else{
             
             return back()->with('error', 'Failed to sent request');
        }       
       
    }


    public function sendLink(Request $request){
        $request->validate([
        'coachEmail' => 'required',
        ]);
        $email= $request->coachEmail;
        $mobile= $request->mobile;
        $msg= $request->msg;


        $user_id= Auth()->user()->id;
        $senderDetail = User::where('id', $user_id)       
        ->first(); 

         $email_data= array(
            'sender_name' =>$senderDetail->username,
            'sender_email' => $senderDetail->email, 
            'msg' => $msg,   
            'link_type' => 'Registration',        
        );

        Mail::to($email)->send(new LinkMail($email_data));
       return redirect('/athlete/new-recomendation')->with('success','Link send Successfully');
    }

    //==Send Profile Link
     public function sendProfileLink(Request $request){
        $request->validate([
        'coachEmail' => 'required',
        ]);
        $email= $request->coachEmail;
        $mobile= $request->mobile;
        $msg= $request->msg;

        $user_id= Auth()->user()->id;
        $senderDetail = User::where('id', $user_id)       
        ->first(); 

         $email_data= array(
            'sender_name' =>$senderDetail->username,
            'sender_email' => $senderDetail->email, 
            'msg' => $msg, 
            'profile_id' => $user_id,  
            'link_type' => 'Profile',        
        );


        Mail::to($email)->send(new ProfileLinkMail($email_data));
       return redirect('/athlete/new-recomendation')->with('success','Link send Successfully');
    }

    public function postRecommend($id=""){ 
         
        $recommendId=$id;      
       if(Recommendation::where('id', $recommendId)->update(['status'=>1])){            
        
        return response()->json([
            'success' => true,
            'data'=> 'Recommend',
            'message'=>'Recommendation Posted Succesfully'
        ], 200);
        }else{
            return back()->with('error', 'Failed to post recommend');
        }
    }

    public function nopostRecommend($id=""){        
        $recommendId=$id;       
       if(Recommendation::where('id', $recommendId)->update(['status'=>2])){            
        
        return response()->json([
            'success' => true,
            'data'=> 'Recommend',
            'message'=>'Recommendation not posted!!'
        ], 200);
        }else{
            return back()->with('error', 'Oops!! Something went wrong');
        }
    }

    public function contactCoach(Request $request){
        $recommend_id = $request->input('recommend_id');
        $reply_msg = $request->input('reply_msg');
        
        Recommendation::where('id', $recommend_id)->update(['reply_msg'=>$reply_msg, 'status'=>3]);
        return back()->with('success', 'Message sent successfully!!');

         //return redirect('/athlete/dashboard')->with('success','Message sent successfully!!');
    }

    public function saveOrder(Request $request){
        $recommend_id = $request->input('recommend_id');
        $order_no = $request->input('orderno');
       // echo $order_no;exit;

        
        Recommendation::where('id', $recommend_id)->update(['order_no'=>$order_no]);
        
        return 1;
         
    }
}
