<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Education;
use App\Models\UserPhysicalInformation;
use App\Models\UserSportPosition;
use App\Models\Sport;
use App\Models\SchoolPlaying;
use App\Models\UserAddress;
use App\Models\State;
use App\Models\Country;
use App\Models\City;
use App\Models\UserSport;
use App\Models\Travel;
use App\Models\UserWorkoutLibrary;
use App\Models\WorkoutLibrary;
use App\Models\WorkoutCategory;
use App\Models\Gamehighlight;
use App\Models\VideoEvidence;
use App\Models\Teaming;
use App\Models\TeamingGroupUser;
use App\Models\Follower;
use App\Models\UserAciIndexLog;
use App\Models\CoachInformation;
use App\Models\Events;
use App\Models\College;
use App\Models\CoachLevel;
use DB;
use Illuminate\Support\Facades\Hash;


class UserProfileController extends Controller
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
    public function index($id)
    {
        //echo $userType;exit;
       $user_id= $id;
       $user = User::where('id', $user_id)        
        ->with('physicalInfo')
        ->first();

        $user_detail= User::where('id', $user_id)
                            ->first();


       $is_follow= DB::select("SELECT * FROM  followers  WHERE (follower_id = '".$user_id."' OR  user_id = '".$user_id."') AND  (follower_id = '".Auth()->user()->id."' OR  user_id = '".Auth()->user()->id."') AND status=2");
      
        if($user->role_id==2){
            return view('frontend.coach.profile.index');
        }else{

       $school_level ="";
       
       $user_physicalInfo=  UserPhysicalInformation::where('user_id', $user_id)
                            ->first(); 

       $user_sport=UserSport::leftJoin('sports', 'user_sports.sport_id', '=', 'sports.id')->where('user_sports.user_id', $user_id)
      ->get();

        $user_sportposInfo=  UserSportPosition::where('user_id', $user_id)
                            ->first(); 
                            
        if($user_sportposInfo){
            $school_level=  SchoolPlaying::where('id', $user_sportposInfo->school_level_id)
                            ->first(); 
        }
        $sport_detail = [];
        if(!empty($user_sportposInfo)){
        $sport_detail=  Sport::where('id', $user_sportposInfo->sport_id)
                            ->first(); 
        }

        $user_education="";
        if(@$user_physicalInfo->education_id!=""){
            $user_education= Education::where('id', $user_physicalInfo->education_id)->first();
        }      
        
       
        $state_detail=  State::where('id', @$address_info->state_id)
                            ->first(); 

        $workout_library = UserWorkoutLibrary::where('user_id', $id)->where('status', 1)->get();
        $workout_librarys = [];
        if(count($workout_library) > 0){
            foreach($workout_library as $key => $val){
                $temp = WorkoutLibrary::where('status', 1)->where('id', $val->workout_library_id)->first();
                if($temp){
                    $cat = WorkoutCategory::where('status', 1)->where('id', $val->workout_id)->first();
                    $temp['category_title'] =  $cat->category_title;
                    $temp['category_id'] =  $cat->id;
                    $temp['user_id'] =  $val->user_id;
                    $workout_librarys[] = $temp;
                }
            }
        }
        $game_highlight = Gamehighlight::where('status', 1)->where('user_id', $id)->get();
        $video_evidence = VideoEvidence::where('status', 1)->where('user_id', $id)->get();

        //====Score Set====
         $all_month = array('1','2','3','4','5','6','7','8','9','10','11','12');

        $temp = array();
        $all_aci_value_old = array();
        
        $score_dataset = array();
        foreach ($all_month as $single_month) {

          if(date('m') >= $single_month){

            $all_val = UserAciIndexLog::where('user_id', $user_id)->whereYear( 'created_at', date('Y'))->whereMonth( 'created_at', $single_month)->get();
            
            $count_val = count($all_val);
            
            foreach($all_val as $v){
              $all_aci_value_old[] = $v->aci_index;                    
            }
            $all_aci_value_old_total = array_sum($all_aci_value_old);
               
            $temp['value'] = '';

            if($count_val!=0){
              $temp['value'] = $all_aci_value_old_total != 0 ? $all_aci_value_old_total/$count_val : 0 ;

            }
            $monthNum = $single_month;
            $temp['month'] = date("F", mktime(0, 0, 0, $monthNum, 10));
                // $temp['count_val'] = $count_val;
          }
          $score_dataset[] = $temp;          
        }                                       
        // $teamingup_group = TeamingGroupUser::where('status', 0)->where('user_id', $id)->get();

        $teamingup_group =DB::table('teamingup_group')
        ->join('teamingup_group_users','teamingup_group.id', '=', 'teamingup_group_users.teaming_group_id')

         ->select('teamingup_group.id','teamingup_group.group_name','teamingup_group.description','teamingup_group.image','teamingup_group.created_by','teamingup_group_users.user_id','teamingup_group_users.is_joined')->where('teamingup_group_users.user_id', $id)->where('teamingup_group.created_by', $id)->orWhere('teamingup_group_users.user_id', $id)->groupBy('teamingup_group.id')
        ->get();

        $follower = Follower::where('follower_id', $user_id)->get();
        $following = Follower::where('user_id', $user_id)->get();
        //print_r($user);exit;
         //Recommendation
        $recommended_coach_list =DB::table('recommendation')
        ->leftjoin('users','recommendation.receiver_id', '=', 'users.id')
        ->leftJoin('user_address','users.id', '=', 'user_address.user_id')
        ->leftJoin('countries','countries.id', '=', 'user_address.country_id')

         ->select('recommendation.id as recommend_id','recommendation.recommendation','recommendation.created_at','recommendation.receiver_id as coach_id','users.username','users.profile_image',
            'countries.name as country_name')
         ->whereIn('recommendation.recommend_status', [1,3])
         ->where('recommendation.status', 1)
         ->where('recommendation.sender_id', $user_id)
         //->groupBy('users.id')
        ->get(); 
        
        return view('frontend.user-profile')
            ->with('user', $user) 
             ->with('user_physicalInfo', $user_physicalInfo)
             ->with('school_level', $school_level)
             ->with('sport_detail', $sport_detail)
             ->with('user_education', $user_education)
             ->with('state_detail', $state_detail)
             ->with('workout_librarys', $workout_librarys)
             ->with('game_highlight', $game_highlight)
             ->with('video_evidence', $video_evidence)
             ->with('teamingup_group', $teamingup_group)
             ->with('recommended_coach_list', $recommended_coach_list)
             ->with('follower', $follower)
             ->with('following', $following)
             ->with('user_detail', $user_detail)
             ->with('is_follow', $is_follow)
             ->with('user_sport', $user_sport)
             ->with('score_dataset', $score_dataset)             
             ->with('user_sportposInfo', $user_sportposInfo); 
             }         
    }

    //Follower
  public function follower($id){
    $follower_list = Follower::where('follower_id', $id)
            ->get();


     return view('frontend.user.follow.follower-list')
        ->with('follower_list', $follower_list);
    }

    public function following($id){
    $following_list = Follower::where('user_id', $id)
            ->get();

     return view('frontend.user.follow.following-list')
        ->with('following_list', $following_list);
    }

    //==Coach Profile==
public function coachProfile(Request $request,$id, $userType)
    {

        if($userType=='athlete'){
            $file_path='frontend.athlete.profile.coach-profile';
        }else{
            $file_path='frontend.coach.profile.coach-profile';
        }
        $user_id= $id;
        $user = User::where('id', $user_id)       
        ->first();

        $group =DB::table('teamingup_group')
        ->leftjoin('teamingup_group_users','teamingup_group.id', '=', 'teamingup_group_users.teaming_group_id')

        ->select('teamingup_group.id','teamingup_group.group_name','teamingup_group.description','teamingup_group.image','teamingup_group.created_by','teamingup_group_users.user_id','teamingup_group_users.is_joined')->where('teamingup_group.created_by', $user_id)->groupBy('teamingup_group.id')
        ->get();        

        $college="";
        $level_detail="";
        $coach_info = CoachInformation::where('user_id', $user_id)->first();

        $is_follow= DB::select("SELECT * FROM  followers  WHERE (follower_id = '".$user_id."' OR  user_id = '".$user_id."') AND  (follower_id = '".Auth()->user()->id."' OR  user_id = '".Auth()->user()->id."') AND status=2");

          
        if($coach_info){
            $college = College::where('id', $coach_info->college_id)->first();
             $level_detail = CoachLevel::where('id', $coach_info->coaching_level )
            ->first();
        }

        $sports =DB::table('sports')
        ->leftjoin('user_sports','sports.id', '=', 'user_sports.sport_id')

        ->select('sports.name as sportname','sports.id')
        ->where('user_sports.user_id', $user_id)
        ->where('user_sports.status', 1)
        ->first();

        $last_attend_event = Events::where('status', 1)->where('end_date','<=', date('m/d/Y', time()))->get();
        $upcoming_event = Events::where('status', 1)->where('start_date','>=', date('m/d/Y', time()))->get();

        return view($file_path)
        ->with('user', $user)
        ->with('teamingup_group', $group)
        ->with('user_info', $coach_info)
        ->with('sports', $sports)
        ->with('level_detail', $level_detail)
        ->with('last_attend_event', $last_attend_event)
        ->with('is_follow', $is_follow)
        ->with('upcoming_event', $upcoming_event);
    }



    public function athleteProfile($id, $userType)
    {
     // echo Auth()->user()->id;exit;
      if(Auth()->user()->id){

        $user_id= $id;       
        if($userType=='athlete'){
            $file_path='frontend.athlete.profile.athlete-profile';
        }else{
            $file_path='frontend.coach.profile.athlete-profile';
        }
       
       $user = User::where('id', $user_id)        
        ->with('physicalInfo')
        ->first();

        $user_detail= User::where('id', $user_id)
                            ->first();


       $is_follow= DB::select("SELECT * FROM  followers  WHERE (follower_id = '".$user_id."' OR  user_id = '".$user_id."') AND  (follower_id = '".Auth()->user()->id."' OR  user_id = '".Auth()->user()->id."') AND status=2");
      
        if($user->role_id==2){
            return view('frontend.coach.profile.index');
        }else{

       $school_level ="";
       
       $user_physicalInfo=  UserPhysicalInformation::where('user_id', $user_id)
                            ->first(); 

       $user_sport=UserSport::leftJoin('sports', 'user_sports.sport_id', '=', 'sports.id')->where('user_sports.user_id', $user_id)
      ->get();

        $user_sportposInfo=  UserSportPosition::where('user_id', $user_id)
                            ->first(); 
                            
        if($user_sportposInfo){
            $school_level=  SchoolPlaying::where('id', $user_sportposInfo->school_level_id)
                            ->first(); 
        }
        $sport_detail = [];
        if(!empty($user_sportposInfo)){
        $sport_detail=  Sport::where('id', $user_sportposInfo->sport_id)
                            ->first(); 
        }

        $user_education="";
        if(@$user_physicalInfo->education_id!=""){
            $user_education= Education::where('id', $user_physicalInfo->education_id)->first();
        }      
        
       
        $state_detail=  State::where('id', @$address_info->state_id)
                            ->first(); 

        $workout_library = UserWorkoutLibrary::where('user_id', $id)->where('status', 1)->get();
        $workout_librarys = [];
        if(count($workout_library) > 0){
            foreach($workout_library as $key => $val){
                $temp = WorkoutLibrary::where('status', 1)->where('id', $val->workout_library_id)->first();
                if($temp){
                    $cat = WorkoutCategory::where('status', 1)->where('id', $val->workout_id)->first();
                    $temp['category_title'] =  $cat->category_title;
                    $temp['category_id'] =  $cat->id;
                    $temp['user_id'] =  $val->user_id;
                    $workout_librarys[] = $temp;
                }
            }
        }
        $game_highlight = Gamehighlight::where('status', 1)->where('user_id', $id)->get();
        $video_evidence = VideoEvidence::where('status', 1)->where('user_id', $id)->get();

        //====Score Set====
         $all_month = array('1','2','3','4','5','6','7','8','9','10','11','12');

        $temp = array();
        $all_aci_value_old = array();
        
        $score_dataset = array();
        foreach ($all_month as $single_month) {

          if(date('m') >= $single_month){

            $all_val = UserAciIndexLog::where('user_id', $user_id)->whereYear( 'created_at', date('Y'))->whereMonth( 'created_at', $single_month)->get();
            
            $count_val = count($all_val);
            
            foreach($all_val as $v){
              $all_aci_value_old[] = $v->aci_index;                    
            }
            $all_aci_value_old_total = array_sum($all_aci_value_old);
               
            $temp['value'] = '';

            if($count_val!=0){
              $temp['value'] = $all_aci_value_old_total != 0 ? $all_aci_value_old_total/$count_val : 0 ;

            }
            $monthNum = $single_month;
            $temp['month'] = date("F", mktime(0, 0, 0, $monthNum, 10));
                // $temp['count_val'] = $count_val;
          }
          $score_dataset[] = $temp;          
        }                                       
        // $teamingup_group = TeamingGroupUser::where('status', 0)->where('user_id', $id)->get();

        $teamingup_group =DB::table('teamingup_group')
        ->join('teamingup_group_users','teamingup_group.id', '=', 'teamingup_group_users.teaming_group_id')

         ->select('teamingup_group.id','teamingup_group.group_name','teamingup_group.description','teamingup_group.image','teamingup_group.created_by','teamingup_group_users.user_id','teamingup_group_users.is_joined')->where('teamingup_group_users.user_id', $id)->where('teamingup_group.created_by', $id)->orWhere('teamingup_group_users.user_id', $id)->groupBy('teamingup_group.id')
        ->get();

        $follower = Follower::where('follower_id', $user_id)->get();
        $following = Follower::where('user_id', $user_id)->get();

         //Recommendation
        $recommended_coach_list =DB::table('recommendation')
        ->leftjoin('users','recommendation.receiver_id', '=', 'users.id')
        ->leftJoin('user_address','users.id', '=', 'user_address.user_id')
        ->leftJoin('countries','countries.id', '=', 'user_address.country_id')

         ->select('recommendation.id as recommend_id','recommendation.recommendation','recommendation.created_at','recommendation.receiver_id as coach_id','users.username','users.profile_image',
            'countries.name as country_name')
         //->where('recommendation.recommend_status', 1)
          ->whereIn('recommendation.recommend_status', [1,3])
         ->where('recommendation.status', 1)
         ->where('recommendation.sender_id', $user_id)
          ->orderBy('recommendation.order_no', 'asc')
         //->groupBy('users.id')
        ->get(); 
        
        return view($file_path)
            ->with('user', $user) 
             ->with('user_physicalInfo', $user_physicalInfo)
             ->with('school_level', $school_level)
             ->with('sport_detail', $sport_detail)
             ->with('user_education', $user_education)
             ->with('state_detail', $state_detail)
             ->with('workout_librarys', $workout_librarys)
             ->with('game_highlight', $game_highlight)
             ->with('video_evidence', $video_evidence)
             ->with('teamingup_group', $teamingup_group)
             ->with('recommended_coach_list', $recommended_coach_list)
             ->with('follower', $follower)
             ->with('following', $following)
             ->with('user_detail', $user_detail)
             ->with('is_follow', $is_follow)
             ->with('user_sport', $user_sport)
             ->with('score_dataset', $score_dataset)             
             ->with('user_sportposInfo', $user_sportposInfo); 
             } 
             }else{
                  return redirect("/login")->with('error','Please Login!!');
             }        
    }


//=====Publically Accesible======
     public function userprofile($id)
    {
      
       $user_id= $id;
       $user = User::where('id', $user_id)        
        ->with('physicalInfo')
        ->first();

        $user_detail= User::where('id', $user_id)
                            ->first();


      // $is_follow= DB::select("SELECT * FROM  followers  WHERE (follower_id = '".$user_id."' OR  user_id = '".$user_id."') AND  (follower_id = '".Auth()->user()->id."' OR  user_id = '".Auth()->user()->id."') AND status=2");
      
        if($user->role_id==2){
            return view('frontend.coach.profile.index');
        }else{

       $school_level ="";
       
       $user_physicalInfo=  UserPhysicalInformation::where('user_id', $user_id)
                            ->first(); 

       $user_sport=UserSport::leftJoin('sports', 'user_sports.sport_id', '=', 'sports.id')->where('user_sports.user_id', $user_id)
      ->get();

        $user_sportposInfo=  UserSportPosition::where('user_id', $user_id)
                            ->first(); 
                            
        if($user_sportposInfo){
            $school_level=  SchoolPlaying::where('id', $user_sportposInfo->school_level_id)
                            ->first(); 
        }
        $sport_detail = [];
        if(!empty($user_sportposInfo)){
        $sport_detail=  Sport::where('id', $user_sportposInfo->sport_id)
                            ->first(); 
        }

        $user_education="";
        if(@$user_physicalInfo->education_id!=""){
            $user_education= Education::where('id', $user_physicalInfo->education_id)->first();
        }      
        
       
        $state_detail=  State::where('id', @$address_info->state_id)
                            ->first(); 

        $workout_library = UserWorkoutLibrary::where('user_id', $id)->where('status', 1)->get();
        $workout_librarys = [];
        if(count($workout_library) > 0){
            foreach($workout_library as $key => $val){
                $temp = WorkoutLibrary::where('status', 1)->where('id', $val->workout_library_id)->first();
                if($temp){
                    $cat = WorkoutCategory::where('status', 1)->where('id', $val->workout_id)->first();
                    $temp['category_title'] =  $cat->category_title;
                    $temp['category_id'] =  $cat->id;
                    $temp['user_id'] =  $val->user_id;
                    $workout_librarys[] = $temp;
                }
            }
        }
        $game_highlight = Gamehighlight::where('status', 1)->where('user_id', $id)->get();
        $video_evidence = VideoEvidence::where('status', 1)->where('user_id', $id)->get();

        //====Score Set====
         $all_month = array('1','2','3','4','5','6','7','8','9','10','11','12');

        $temp = array();
        $all_aci_value_old = array();
        
        $score_dataset = array();
        foreach ($all_month as $single_month) {

          if(date('m') >= $single_month){

            $all_val = UserAciIndexLog::where('user_id', $user_id)->whereYear( 'created_at', date('Y'))->whereMonth( 'created_at', $single_month)->get();
            
            $count_val = count($all_val);
            
            foreach($all_val as $v){
              $all_aci_value_old[] = $v->aci_index;                    
            }
            $all_aci_value_old_total = array_sum($all_aci_value_old);
               
            $temp['value'] = '';

            if($count_val!=0){
              $temp['value'] = $all_aci_value_old_total != 0 ? $all_aci_value_old_total/$count_val : 0 ;

            }
            $monthNum = $single_month;
            $temp['month'] = date("F", mktime(0, 0, 0, $monthNum, 10));
                // $temp['count_val'] = $count_val;
          }
          $score_dataset[] = $temp;          
        }                                       
        // $teamingup_group = TeamingGroupUser::where('status', 0)->where('user_id', $id)->get();

        $teamingup_group =DB::table('teamingup_group')
        ->join('teamingup_group_users','teamingup_group.id', '=', 'teamingup_group_users.teaming_group_id')

         ->select('teamingup_group.id','teamingup_group.group_name','teamingup_group.description','teamingup_group.image','teamingup_group.created_by','teamingup_group_users.user_id','teamingup_group_users.is_joined')->where('teamingup_group_users.user_id', $id)->where('teamingup_group.created_by', $id)->orWhere('teamingup_group_users.user_id', $id)->groupBy('teamingup_group.id')
        ->get();

        $follower = Follower::where('follower_id', $user_id)->get();
        $following = Follower::where('user_id', $user_id)->get();
        //print_r($user);exit;
         //Recommendation
        $recommended_coach_list =DB::table('recommendation')
        ->leftjoin('users','recommendation.receiver_id', '=', 'users.id')
        ->leftJoin('user_address','users.id', '=', 'user_address.user_id')
        ->leftJoin('countries','countries.id', '=', 'user_address.country_id')

         ->select('recommendation.id as recommend_id','recommendation.recommendation','recommendation.created_at','recommendation.receiver_id as coach_id','users.username','users.profile_image',
            'countries.name as country_name')
         ->whereIn('recommendation.recommend_status', [1,3])
         ->where('recommendation.status', 1)
         ->where('recommendation.sender_id', $user_id)
         //->groupBy('users.id')
        ->get(); 
        
        return view('frontend.userprofile')
            ->with('user', $user) 
             ->with('user_physicalInfo', $user_physicalInfo)
             ->with('school_level', $school_level)
             ->with('sport_detail', $sport_detail)
             ->with('user_education', $user_education)
             ->with('state_detail', $state_detail)
             ->with('workout_librarys', $workout_librarys)
             ->with('game_highlight', $game_highlight)
             ->with('video_evidence', $video_evidence)
             ->with('teamingup_group', $teamingup_group)
             ->with('recommended_coach_list', $recommended_coach_list)
             ->with('follower', $follower)
             ->with('following', $following)
             ->with('user_detail', $user_detail)
            // ->with('is_follow', $is_follow)
             ->with('user_sport', $user_sport)
             ->with('score_dataset', $score_dataset)             
             ->with('user_sportposInfo', $user_sportposInfo); 
             }         
    }

   

    
   

   

}
