<?php

namespace App\Http\Controllers\Frontend\Coach;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\CoachInformation;
use App\Models\College;
use DB;
use App\Models\CoachLevel;
use App\Models\Teaming;
use App\Models\Sport;
use App\Models\Follower;
use App\Models\ReverseLookup;


class DashboardController extends Controller
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
        $user_detail=  User::where('id', $user_id)
                            ->first();
                          
        $college="";
        $level_detail="";
        $coach_info = CoachInformation::where('user_id', $user_id)->first();
        if($coach_info){
            $college = College::where('id', $coach_info->college_id)->first();
             $level_detail = CoachLevel::where('id', $coach_info->coaching_level )
            ->first();
        }
        //print_r($coach_info);exit;
        
         $teaming=  Teaming::where('created_by', $user_id)->skip(0)->take(2)->get();
              

        $recommend_request =DB::table('recommendation')
        ->leftjoin('users','recommendation.sender_id', '=', 'users.id')

        ->select('recommendation.recommend_status','recommendation.id as recommend_id','recommendation.request_purpose', 'users.username','users.id as athleteId','users.year','users.profile_image')
        ->where('recommendation.receiver_id', $user_id)
        ->where('recommendation.recommend_status', 0)
        ->groupBy('recommendation.sender_id')
        ->get();
        
        $sports =DB::table('sports')
        ->leftjoin('user_sports','sports.id', '=', 'user_sports.sport_id')

        ->select('sports.name as sportname','sports.id')
        ->where('user_sports.user_id', $user_id)
        ->where('user_sports.status', 1)
        ->first();

         $follower = Follower::where('follower_id', Auth()->user()->id)->where('status', 1)->get();

        $following = Follower::where('user_id', Auth()->user()->id)->get();

         $reverseList = ReverseLookup::where('status', '!=', 3 )->where('user_id', Auth()->user()->id)->get();
         
       
        return view('frontend.coach.dashboard.index')
        ->with('user_detail', $user_detail)
        ->with('user_info', $coach_info)
        ->with('college', $college)
        ->with('level_detail', $level_detail)
        ->with('recommend_request', $recommend_request)
        ->with('teaming', $teaming)
        ->with('sports', $sports)
        ->with('follower', $follower)
        ->with('following', $following)
        ->with('reverseList', $reverseList);
    }

    public function logout() {
        Session::flush();
        Auth::logout();  
        return redirect('/')->with('success','User Logout Successfully');
    }

    public function requestResponse(Request $request){
        $follower_id = $request->follower_id;
        $status= $request->status;
        if($status==2){
            $message="Accepted";
        }else{
            $message="Rejected";
        }
        $res = Follower::where('id', $follower_id)
        ->first();
        $res->status = $status;
        if($res->save()){
            return response()->json([
                'success' => true,
                'message' => $message
            ], 200);
        }

    }

    
}
