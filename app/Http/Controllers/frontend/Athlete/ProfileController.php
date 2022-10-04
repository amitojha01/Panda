<?php

namespace App\Http\Controllers\Frontend\Athlete;

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
use App\Models\GuardianInformation;
use App\Models\UserWorkoutLibrary;
use App\Models\WorkoutLibrary;
use App\Models\WorkoutCategory;
use App\Models\UserWorkoutExercises;
use App\Models\UserAciIndex;
use App\Models\UserAciIndexLog;
use App\Models\AciCalculationData;
use App\Models\Events;
use App\Models\VideoEvidence;
use App\Models\Gamehighlight;
use App\Models\Recommendation;
use DB;
use App\Models\Follower;
use App\Models\College;
use App\Models\UserCollege;
use App\Models\Competition;
use App\Mail\ChangeProfileMail;
use App\Mail\ChangePasswordMail;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
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
     $user = User::where('id', $user_id)        
     ->with('physicalInfo')       
     ->first();

       // $user_physicalInfo=  UserPhysicalInformation::where('user_id', $user_id)
       //                      ->first(); 
       //  $user_sportposInfo=  UserSportPosition::where('user_id', $user_id)
       //                      ->first(); 
       //                      // dd($user_sportposInfo);
       // // if(!$user_sportposInfo->isNull()) {
       // //  $school_level=  SchoolPlaying::where('id', $user_sportposInfo->school_level_id)
       // //                      ->first(); 
       // //  }

     $state_detail=  State::where('id', @$address_info->state_id)
     ->first();  



        // Workout list
     $workout_library = UserWorkoutLibrary::where('user_id', Auth()->user()->id)->where('status', 1)->get();
     $workout_librarys = [];
     if(count($workout_library) > 0){
      foreach($workout_library as $key => $val){
        $temp = WorkoutLibrary::where('status', 1)->where('id', $val->workout_library_id)->first();
        if($temp){
          
          $cat = WorkoutCategory::where('status', 1)->where('id', $val->workout_id)->first();
          $temp['category_title'] =  $cat->category_title;
          $temp['category_id'] =  $cat->id;
          $workout_librarys[] = $temp;
        }
      }
    }
    
    $user_id= Auth()->user()->id;
    $user_detail=  User::where('id', $user_id)
    ->first();
    $user_physicalInfo=  UserPhysicalInformation::where('user_id', $user_id)
    ->first(); 
    $user_education="";
    if(@$user_physicalInfo->education_id!=""){
      $user_education= Education::where('id', $user_physicalInfo->education_id)->first();
    }    
    

    $user_sport=UserSport::leftJoin('sports', 'user_sports.sport_id', '=', 'sports.id')->where('user_sports.user_id', $user_id)
    ->get();


    $user_sportposInfo=  UserSportPosition::where('user_id', $user_id)
    ->first();
    $sport_detail = [];
    if(!empty($user_sportposInfo)){
      $sport_detail=  Sport::where('id', $user_sportposInfo->sport_id)
      ->first(); 
    }
    $school_level = [];
    if(!empty($user_sportposInfo)){
      $school_level=  SchoolPlaying::where('id', $user_sportposInfo->school_level_id)
      ->first();
    }

    $allWorkoutCategory = WorkoutCategory::where('status', 1)->orderBy('is_aci_index', 'desc')->get();
    
    $aci_score = UserAciIndex::where('user_id', Auth()->user()->id)->first();

    $video_evidence = VideoEvidence::where('status', 1)->where('user_id', Auth()->user()->id)->get();

    $game_highlight = Gamehighlight::where('status', 1)->where('user_id', Auth()->user()->id)->get();

    

    $upcoming_event= DB::select("SELECT * FROM  events  WHERE (start_date >= '".date('Y-m-d')."' AND  end_date >= '".date('Y-m-d')."' AND `user_id` = '".Auth()->user()->id."') OR  (start_date <= '".date('Y-m-d')."' AND  end_date >= '".date('Y-m-d')."' AND `user_id` = '".Auth()->user()->id."')  AND `status` =1");

    $last_attend_event= DB::select("SELECT * FROM  events  WHERE (start_date <= '".date('Y-m-d')."' AND  end_date <= '".date('Y-m-d')."')  AND `user_id` = '".Auth()->user()->id."' AND `status` =1");

    

        /**
         * Calculate log records
        */
        $all_aci_score = UserAciIndexLog::where('user_id', Auth()->user()->id)->get();
        $temp_score_dataset = array();
        $score_dataset = array();
        if($all_aci_score){
          foreach($all_aci_score as $key => $val){
            $months = date('M', strtotime($val->created_at));
            $temp_score_dataset[$months][] = $val->aci_index;
          }
          if(!empty($temp_score_dataset)){
            foreach($temp_score_dataset as $k => $v){
              $score_dataset[] = array(
                'value' =>array_sum($v)/count($v),
                'month'=> $k
              );
            }
          }
        }           

        $aci_rank = $this->aciRankCalculate();

        //===Score Set===
        $all_month = array('1','2','3','4','5','6','7','8','9','10','11','12');

        $months = [];
        $temp = [];
        $month = time();
        for ($i = 2; $i <= 12; $i++) {
        $month = strtotime('last month', $month);
        $temp['month'] = date("m", $month);
        $temp['year'] = date("Y", $month);
        $months[] = $temp;
        }
        $months1[13]['month'] = date("m", time());
        $months1[13]['year'] = date("Y", time());
       
        $months = array_reverse($months);
        $months = array_merge($months,$months1);

        $temp = array();
        $all_aci_value_old = array();
        
        $score_dataset = array();
        foreach ($months as $single_month) {
            // print_r($single_month); die;
          if(!empty($single_month)){
            // if(date('m') >= $single_month){

            $all_val = UserAciIndexLog::where('user_id', Auth()->user()->id)->whereYear( 'created_at', $single_month['year'])->whereMonth( 'created_at', $single_month['month'])->orderBy('aci_index', 'desc')->take(1)->get();
            // echo $single_month;
            // echo "<pre>";
            // print_r($all_val);
                //  $count_val = count($all_val);
            // echo $count_val;exit;

                // foreach($all_val as $v){
                //     $all_aci_value_old[] = $v->aci_index;                    
                // }
                // $all_aci_value_old_total = array_sum($all_aci_value_old);
                // //echo $all_aci_value_old_total;exit;
            
                // $temp['value'] = '';

                // if($count_val!=0){
                //     $temp['value'] = $all_aci_value_old_total != 0 ? $all_aci_value_old_total/$count_val : 0 ;

                // }
            if(count($all_val) != 0){
                $temp['value'] = $all_val[0]['aci_index'];
            }
            else{
                $temp['value'] = 0;
            }
            

            $monthNum = $single_month['month'];
            $temp['month'] = date("M", mktime(0, 0, 0, $monthNum, 10));
                // $temp['count_val'] = $count_val;
        }
        $score_dataset[] = $temp;
        
        
    }

        // $teamingup_group = TeamingGroupUser::where('status', 0)->where('user_id', $id)->get();

        $teamingup_group =DB::table('teamingup_group')
        ->join('teamingup_group_users','teamingup_group.id', '=', 'teamingup_group_users.teaming_group_id')

        ->select('teamingup_group.id','teamingup_group.group_name','teamingup_group.description','teamingup_group.image','teamingup_group.created_by','teamingup_group_users.user_id','teamingup_group_users.is_joined')->where('teamingup_group_users.user_id', Auth()->user()->id)->orwhere('teamingup_group.created_by', Auth()->user()->id)->orWhere('teamingup_group_users.user_id', Auth()->user()->id)->groupBy('teamingup_group.id')
        ->get();

        //Recommendation
        $recommended_coach_list =DB::table('recommendation')
        ->leftjoin('users','recommendation.receiver_id', '=', 'users.id')

        ->leftJoin('user_address','users.id', '=', 'user_address.user_id')

        ->leftJoin('countries','countries.id', '=', 'user_address.country_id')

        ->select('recommendation.id as recommend_id','recommendation.recommendation','recommendation.created_at','recommendation.receiver_id as coach_id','users.username','users.profile_image',
          'countries.name as country_name')
        ->whereIn('recommendation.recommend_status', [1,3])
       // ->where('recommendation.recommend_status', 1)
        ->where('recommendation.status', 1)
        ->where('recommendation.sender_id', Auth()->user()->id)
        ->orderBy('recommendation.order_no', 'asc')
        //->groupBy('users.id')
        ->get(); 

        $follower = Follower::where('follower_id', Auth()->user()->id)->where('status', 2)->get();
        $following = Follower::where('user_id', Auth()->user()->id)->where('status', 2)->get();


        return view('frontend.athlete.profile.index')
        ->with('user', $user) 
        ->with('state_detail', $state_detail)
        ->with('workout_librarys', $workout_librarys)
        ->with('user_detail', $user_detail)
        ->with('user_physicalInfo', $user_physicalInfo)
        ->with('sport_detail', $sport_detail)
        ->with('aci_score', $aci_score)
        ->with('school_level', $school_level)       
        ->with('video_evidence', $video_evidence)       
        ->with('game_highlight', $game_highlight)        
        ->with('last_attend_event', $last_attend_event)      
        ->with('score_dataset', $score_dataset)
        ->with('upcoming_event', $upcoming_event)
        ->with('user_education', $user_education)
        ->with('aci_rank', $aci_rank) 
        ->with('recommended_coach_list', $recommended_coach_list)
        ->with('teamingup_group', $teamingup_group)
        ->with('follower', $follower)
        ->with('following', $following)
        ->with('user_sport', $user_sport)
        ->with('user_sportposInfo', $user_sportposInfo)
        ->with('allWorkoutCategory', $allWorkoutCategory);      
      }

      public function aciRankCalculate()
      {

       $user_id= Auth()->user()->id;
       $user_detail=  User::where('id', $user_id)->first();

    //  echo  $user_detail->gender ;
    //  echo  $user_detail->year;
       
       $user_index_rank =DB::table('user_aci_indexs')
       ->select('user_aci_indexs.aci_index')
       ->where('user_id', $user_id )
       ->first();
     }

     public function getCollege(){
       $data['college'] = College::where(['status'=> 1, 'type'=> 1])->orderBy('name', 'ASC')->get(); 
       return response()->json($data);
     }


     public function updateCollegeInfo(Request $request, $id){
       $request->validate([
        'college_id' => 'required',
      ]);
       $collegeInfo = UserCollege::where('user_id', $id)
       ->get();     

       if(count($collegeInfo)>0){
        DB::table('user_colleges')->where('user_id', $id)->delete();

        $user_id= $id;

        $college_id = $request->input('college_id');
        for($i=0; $i<count($college_id); $i++){
         $data= array(
          'user_id' => $user_id,
          'college_id' => $college_id[$i]
        );
         UserCollege::insert($data);       
       }   
       return redirect('/athlete/edit-profile')->with('success','College updated  Successfully');  
     }else{
      $user_id= $id;
      $college_id = $request->input('college_id');

      for($i=0; $i<count($college_id); $i++){
       $data= array(
        'user_id' => $user_id,
        'college_id' => $college_id[$i],
      );

       UserCollege::insert($data);   
     }
     return redirect('/athlete/edit-profile')->with('success','College updated  Successfully');
   }
 }



 public function editProfile()
 {

  $user_id= Auth()->user()->id;
  $user = User::where('id', $user_id)        
  ->with('physicalInfo')
  ->with('address')
  ->with('guardian')
  ->first();

  $country= Country::all(); 

  $city="";
  $states="";

  $user_state= @$user->address[0]->state_id;
  if($user_state!=""){
    $city= city::where('state_id', $user_state)
    ->orderBy('name', 'ASC')
    ->get();
  }
  $user_country= @$user->address[0]->country_id;
  if($user_country!=""){
    $states= State::where('country_id', $user_country)
    ->orderBy('name', 'ASC')
    ->get();
  }
  
  //$states= State::all(); 
       // $city= City::all(); 
  //$education = Education::all();
  $education =Education::where('status', 1)->get();
  $school_playingList = SchoolPlaying::where('status', 1)->get();
  $travelList = Travel::where('status', 1)->get();

  //$sport = Sport::all(); 
  $sport = Sport::orderBy('name')->get();


  $sportInfo = UserSport::where('user_id', $user_id)
  ->get();
  $sportPosInfo = UserSportPosition::where('user_id', $user_id)
  ->get();
  $userSports= array();
  $userSportpos= array();
  $user_school_level_id ="";
  $user_other_level_id ="";
  $competition_id= "";

  if($sportInfo){
   for($i=0; $i<count($sportInfo); $i++){
    array_push($userSports, $sportInfo[$i]->sport_id);
  } 
}
if(count($sportPosInfo)>0){
  for($i=0; $i<count($sportPosInfo); $i++){
    array_push($userSportpos, $sportPosInfo[$i]->position_id);
  }
  $user_school_level_id= $sportPosInfo[0]->school_level_id;
  $user_other_level_id= $sportPosInfo[0]->other_level_id;
  $competition_id= $sportPosInfo[0]->competition_id;
}

$college_list= College::where(['status'=> 1, 'type'=> 1])->orderBy('name', 'ASC')->get(); 

$collegeInfo = UserCollege::where('user_id', $user_id)
->get();       
$userCollege=array();

if($collegeInfo){
  for($i=0; $i<count($collegeInfo); $i++){
    array_push($userCollege, $collegeInfo[$i]->college_id);
  } 
}  
$competition = Competition::where(['status'=> 1])->get();        

return view('frontend.athlete.profile.edit-profile')
->with('user', $user)
->with('country', $country)
->with('states', $states)
->with('city', $city) 
->with('education', $education)
->with('sport', $sport)
->with('userSports', $userSports)
->with('userSportpos', $userSportpos)
->with('school_playingList', $school_playingList)
->with('travelList', $travelList)
->with('user_school_level_id', $user_school_level_id)
->with('user_other_level_id', $user_other_level_id)
->with('competition_id', $competition_id)
->with('college_list', $college_list)
->with('userCollege', $userCollege)
->with('competition',  $competition);

} 

public function updateProfile(Request $request,$id){

  $request->validate([
    'username' => 'required|max:255',
    'mobile' => 'required|max:10|min:10',
    'email' => 'required',
    'gender' => 'required',
            //'day' => 'required',
            //'month' => 'required',
            //'year' => 'required',
            ///'graduation_year' => 'required'
  ]);
  $get_year = (date('Y')-12);

  $user = User::find( $id );  
  $prev_profile= $user->profile_type;        
  $user->username = $request->input('username');
  $user->mobile = $request->input('mobile');
  $user->email = $request->input('email');
  $user->gender = $request->input('gender'); 
  $user->profile_type = $request->input('profile_type');
  $user->contact_email = $request->input('contact_email');

  $user->day = $request->input('day');
  $user->month = $request->input('month');        
  $user->year = $request->input('year'); 
  $user->publish_contact = $request->input('publish_contact'); 
  $user->graduation_year = $request->input('graduation_year');      

  if (request()->hasFile('profile_image')) {
    $file = request()->file('profile_image');
    $fileName = time() . "." . $file->getClientOriginalExtension();
    if($file->move('public/uploads/profile/', $fileName)){
      $user->profile_image = 'public/uploads/profile/'.$fileName;
    }
  }
  
  if($user->year >= $get_year){

    $profileType= $request->input('profile_type');
    
    if($prev_profile!= $profileType){
      if($profileType==0){
        $ptype= "Public";
      }else{
        $ptype= "Private";
      }
      $guardian_detail= GuardianInformation::where('user_id', Auth()->user()->id)->first(); 

      $email_data= array(
        'username' => $user->username,
        'ptype' => $ptype

      );
      $email= $guardian_detail->primary_email;

       //return view('emails.change-profile')
       //->with('data', $email_data);
      Mail::to($email)->send(new ChangeProfileMail($email_data));
    }
  }
  $user->save();

  return redirect('/athlete/edit-profile')->with('success','User Update Successfully');
}

public function getSports(){
  //$data['sport'] = Sport::all(); 
   $data['sport']  = Sport::orderBy('name')->get();
  return response()->json($data);
}

public function getState(Request $request)
{
  $data['states'] = DB::table('states')
  ->where('country_id', $request->country_id)
  ->orderBy('name', 'ASC')
  ->get();

  return response()->json($data);
}

public function getCities(Request $request)
{
  $data['cities'] = DB::table('cities')
  ->where('state_id', $request->state_id)
  ->orderBy('name', 'ASC')
  ->get();
  return response()->json($data);
} 

public function updateAddress(Request $request,$id){

  $addressInfo = UserAddress::where('user_id', $id)
  ->first();               
  if($addressInfo ){
    $addressInfo->country_id = $request->input('country_id');
    $addressInfo->state_id = $request->input('state_id');
    $addressInfo->city_id = $request->input('city_id'); 
    $addressInfo->zip = $request->input('zip'); 
    $addressInfo->save();

    return redirect('/athlete/edit-profile')->with('success','Address  updated  Successfully');
  }else{
    $request->validate([
      'country_id' => 'required',
      'state_id' => 'required',
      'city_id' => 'required',
      'zip'     => 'required'   
    ]);
    $data = $request->only('country_id', 'state_id','city_id','zip');
    $data['user_id'] = $id;
    
    if(UserAddress::insert($data)){            
      return redirect('/athlete/edit-profile')->with('success','Address  updated  Successfully');
    }else{
      return back()->with('error', 'Failed to update information');
    }
  }

}

    //Update Guardian
public function updateGuardian(Request $request,$id){

  $guardianInfo = GuardianInformation::where('user_id', $id)
  ->first();
  if($guardianInfo ){
    $guardianInfo->relationship = $request->input('relationship');
    $guardianInfo->first_name = $request->input('first_name');
    $guardianInfo->last_name = $request->input('last_name');
    $guardianInfo->enable_textmessage = $request->input('enable_textmessage');       
    $guardianInfo->primary_phone = $request->input('primary_phone');

    $guardianInfo->primary_phone_type = $request->input('primary_phone_type');
    $guardianInfo->is_primary_text = $request->input('is_primary_text');
    $guardianInfo->secondary_phone = $request->input('secondary_phone');
    $guardianInfo->secondary_phone_type = $request->input('secondary_phone_type');
    $guardianInfo->is_secondary_text = $request->input('is_secondary_text');
    $guardianInfo->primary_email = $request->input('primary_email');
    $guardianInfo->save();
    return redirect('/athlete/edit-profile')->with('success','Guardian Info  updated  Successfully');

  }else{
    $data = $request->only('relationship', 'first_name','last_name','enable_textmessage','primary_phone','primary_phone_type','is_primary_text','secondary_phone', 'secondary_phone_type','is_secondary_text','primary_email','status');
    $data['user_id'] = $id;
    
    if(GuardianInformation::insert($data)){
      return redirect('/athlete/edit-profile')->with('success','Guardian Info  updated  Successfully');
    }else{
      return back()->with('error', 'Failed to update information');
    }
  }

}




public function updatePhysicalInfo(Request $request,$id){

  $physicalInfo = UserPhysicalInformation::where('user_id', $id)
  ->first();

  if($physicalInfo){
    $physicalInfo->height_feet = $request->input('height_feet');
    $physicalInfo->height_inch = $request->input('height_inch');

    $physicalInfo->weight = $request->input('weight');
    
    $physicalInfo->wingspan_feet = $request->input('wingspan_feet');
    $physicalInfo->wingspan_inch = $request->input('wingspan_inch');
    $physicalInfo->head = $request->input('head'); 
    $physicalInfo->education_id = $request->input('education_id');
    $physicalInfo->grade = $request->input('grade');

    $physicalInfo->dominant_hand = $request->input('dominant_hand');
    $physicalInfo->dominant_foot = $request->input('dominant_foot');
    $physicalInfo->save();
    
    return redirect('/athlete/edit-profile')->with('success','Physical Info  updated  Successfully');
  }else{

    $data = $request->only('height_feet', 'height_inch', 'weight','wingspan_feet','wingspan_inch','head','education_id', 'grade');
    $data['user_id'] = $id;
    
    if(UserPhysicalInformation::insert($data)){
      return redirect('/athlete/edit-profile')->with('success','Physical Info  updated  Successfully');
    }else{
      return back()->with('error', 'Failed to update information');
    }
  }

}

public function getSportPosition(Request $request)
{     
  $data['position'] = DB::table('sport_positions')
  ->where('sport_id', $request->sport_id)
  ->where('status', 1)
  ->get();
  return response()->json($data);
}


public function updateSports(Request $request, $id){

 $request->validate([
  'sport_id' => 'required',

]);
 $soprtInfo = UserSport::where('user_id', $id)
 ->get();

 if(count($soprtInfo)>0){

  DB::table('user_sports')->where('user_id', $id)->delete();
  DB::table('user_sport_positions')->where('user_id', $id)->delete();
  $user_id= $id;

  $sport_id = $request->input('sport_id');

  $check_sport_id = $request->input('sprtId');
  $sport_position_id = $request->input('sport_position_id');
  $school_level_id = $request->input('school_level_id');
  $other_level_id = $request->input('other_level_id');
  $competition_id = $request->input('competition_id');

  $n=0;

  for($i=0; $i<count($sport_id); $i++){
   $data= array(
    'user_id' => $user_id,
    'sport_id' => $sport_id[$i]
  );
   UserSport::insert($data); 

   for($k=$n; $k<$n+2; $k++){
    if($sport_id[$i]== $check_sport_id[$i] && $sport_position_id[$k]!=""){
      $positionData= array(
        'user_id' => $user_id,
        'sport_id' => $sport_id[$i],
        'position_id' =>$sport_position_id[$k],
        'school_level_id'=> $school_level_id,
        'other_level_id' => $other_level_id,
        'competition_id' => $competition_id
      );
      UserSportPosition:: insert($positionData);
    }

  }
  $n= $n+2;
}     

return redirect('/athlete/edit-profile')->with('success','Sports information  updated  Successfully');
}else{

  $user_id= $id;
  $sport_id = $request->input('sport_id');
  $check_sport_id = $request->input('sprtId');

  $sport_position_id = $request->input('sport_position_id');
  $school_level_id = $request->input('school_level_id');
  $other_level_id = $request->input('other_level_id');
  $competition_id = $request->input('competition_id');
  
  for($i=0; $i<count($sport_id); $i++){
   $data= array(
    'user_id' => $user_id,
    'sport_id' => $sport_id[$i]
  );
   UserSport::insert($data);
   $n=0;

   for($k=$n; $k<$n+2; $k++){
    if($sport_id[$i]== $check_sport_id[$i] && $sport_position_id[$k]!=""){
      $positionData= array(
        'user_id' => $user_id,
        'sport_id' => $sport_id[$i],
        'position_id' =>$sport_position_id[$k],
        'school_level_id'=> $school_level_id,
        'other_level_id' => $other_level_id,
        'competition_id' => $competition_id
      );
      UserSportPosition:: insert($positionData);
    }

  }
  $n= $n+2;
}

return redirect('/athlete/edit-profile')->with('success','Sports information  updated  Successfully');
}

}

//=====Change Password=======
public function changePassword()
{  
  $user_id= Auth()->user()->id;
  $user = User::where('id', $user_id)
  ->first();

  return view('frontend.athlete.setting.change-password')
  ->with('user', $user);                       
}

public function updatePassword(Request $request, $id){

  $user = User::find( $id ); 
  $new_pwd = $request->input('new_password');
  $confirm_pwd = $request->input('confirm_password');
  $user->password = Hash::make($new_pwd);        
  $data = $request->all();

  if($new_pwd!= $confirm_pwd){
    return back()->with('error','Password not match!!');
  }
  else{
    //===Send Mail==
    $get_year = (date('Y')-12);
    if($user->year >= $get_year){

     $guardian_detail= GuardianInformation::where('user_id', Auth()->user()->id)->first(); 

     $email_data= array(
      'username' => $user->username,
      'new_pwd' => $new_pwd

    );
     $email= $guardian_detail->primary_email;

       //return view('emails.change-password')
       //->with('data', $email_data);
     Mail::to($email)->send(new ChangePasswordMail($email_data));
   }
   
   $user->save();   
   return back()->with('success','Password Updated successfully!!');
 }
}

//Follower
public function follower(){
  $follower_list = Follower::where('follower_id', Auth()->user()->id)
  ->get();


  return view('frontend.athlete.follow.follower-list')
  ->with('follower_list', $follower_list);
}

public function following(){
  $following_list = Follower::where('user_id', Auth()->user()->id)
  
  ->get();

  return view('frontend.athlete.follow.index')
  ->with('following_list', $following_list);
}


public function unfollow(Request $request)
{
  $followId = $request->followid;
  if(Follower::find($followId)->delete()){
    return response()->json([
      'success' => true,
      'message' => 'Unfollowed'
    ], 200);
  }            
}

public function remove(Request $request)
{
  $followId = $request->followid;
  if(Follower::find($followId)->delete()){
    return response()->json([
      'success' => true,
      'message' => 'Removed'
    ], 200);
  }            
}


public function follow_unfollow(Request $request)
{
  $user_id= Auth()->user()->id;
  $followId = $request->followid;
  $data = $request->only('follower_id');
  $data['user_id'] = $user_id;
  $data['follower_id'] = $followId;
  $exist_followers_user = $athlete = Follower::where('status', 1)->where('user_id', $user_id)->where('follower_id', $followId)->first();
  if (empty($exist_followers_user)) {
    if(Follower::insert($data)){  
     return response()->json([
      'success' => true,
      'message' => 'Followed'
    ], 200);
   }
 }else{
   $id=$exist_followers_user->id;
   if(Follower::find($id)->delete()){
    return response()->json([
      'success' => true,
      'message' => 'Unfollowed'
    ], 200);
  }

}
}



public function getRecommendation(Request $request){

 $data['recommendation'] = DB::table('recommendation')->where('id', $request->recomend_id)->get();
 return response()->json($data);        
}

public function changeReadStatus(){ 

  if(Follower::where("read_status",0)->where("user_id", Auth()->user()->id)->orwhere("follower_id", Auth()->user()->id)->update(array('read_status' =>'1'))){
    Recommendation::where("athlete_read_status",0)->where("sender_id", Auth()->user()->id)->update(array('athlete_read_status' =>'1'));

    return 1;
  }else{
    return 0;
  }
}

}
