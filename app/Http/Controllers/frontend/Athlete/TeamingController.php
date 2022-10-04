<?php

namespace App\Http\Controllers\Frontend\Athlete;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teaming;
use App\Models\User;
use App\Models\WorkoutLibrary;
use App\Models\TeamingWorkout;
use App\Models\TeamingGroupUser;
use App\Models\TeamingGroupAdmin;
use App\Models\Sport;
use App\Models\SportPosition;
use App\Models\State;
use App\Models\Competition;

use App\Mail\TeamInvitationMail;
use Illuminate\Support\Facades\Mail;

use App\Models\UserWorkoutLibrary;
use App\Models\WorkoutCategoryLibrary;
use App\Models\WorkoutCategory;
use DB;


class TeamingController extends Controller
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


    public function teamingupGroup()
    {   
        $user_id= Auth()->user()->id;
        $group =DB::table('teamingup_group')
        ->leftjoin('teamingup_group_users','teamingup_group.id', '=', 'teamingup_group_users.teaming_group_id')

        ->select('teamingup_group.id','teamingup_group.group_name','teamingup_group.description','teamingup_group.image','teamingup_group.created_by','teamingup_group_users.user_id','teamingup_group_users.is_joined')->where('teamingup_group.created_by', $user_id)->orWhere('teamingup_group_users.user_id', $user_id)->groupBy('teamingup_group.id')
        ->get();
        
        $allWorkoutCategory = WorkoutCategory::where('status', 1)->orderBy('is_aci_index', 'desc')->get();
        

        $athlete = User::where('role_id', 1)->where('id', '!=',Auth()->user()->id)
        ->with('address')
        ->get();

        $states= State::where('country_id', 231)->get();
        $cities =DB::table('cities')
        ->join('states','states.id', '=', 'cities.state_id')
        ->select('cities.*')
        ->where('states.country_id', 231)
        ->get();
        $sport= Sport::where('status', 1)->get();
        $sport_position= SportPosition::where('status', 1)->get();
        $competition_level= Competition::where('status', 1)->get(); 

        return view('frontend.athlete.teaming.index')
        ->with('group', $group)->with('allWorkoutCategory', $allWorkoutCategory)
        ->with('athlete',$athlete)
        ->with('states', $states)
        ->with('sport', $sport)
        ->with('sport_position', $sport_position)
        ->with('cities', $cities)
        ->with('competition_level', $competition_level);
    }

    public function teamingupGroupDetail($id)
    {   
        $group_admin= array();                       
        $group_detail = Teaming::where('id', $id)->first();
        $group_user= TeamingGroupUser::where('teaming_group_id', $id)->where('is_joined', 1)->get();
        $creator = User::where('id', $group_detail->created_by)
        ->first();
        $groupAdmin= TeamingGroupAdmin::where('teaming_group_id', $id)->get();
        if(count($groupAdmin)>0){
            for($i=0; $i<count($groupAdmin); $i++){
                array_push($group_admin, $groupAdmin[$i]->user_id );
            }

        }
        
        $workout= TeamingWorkout::where('teaming_group_id', $id)->get();
        $category_library_id_array = [];

        foreach($workout as $category_library_id){
            $category_library_id_array[] = $category_library_id['workout_category_librarys_id'];

        }

        $allWorkoutCategory = WorkoutCategory::where('status', 1)->orderBy('is_aci_index', 'desc')->get(); 

        return view('frontend.athlete.teaming.teamingup-group-details')
        ->with('group_detail', $group_detail)
        ->with('group_user', $group_user)
        ->with('allWorkoutCategory', $allWorkoutCategory)
        ->with('category_library_id_array', $category_library_id_array)
        ->with('creator', $creator)
        ->with('workout', $workout)
        ->with('group_admin', $group_admin);
    }
    
    public function addGroupLibrary($group_id, Request $request){

        $workout_id = $request->input('workout_cat_library_array');

        if(count($workout_id)>0){
            DB::table('teamingup_workout')->where('teaming_group_id', $group_id)->delete();
            for($i=0; $i<count($workout_id); $i++){
                $workout_category_det = WorkoutCategoryLibrary::where('id', $workout_id[$i])->first();
                $workoutData= array(
                    'teaming_group_id' => $group_id, 
                    'workout_id' => $workout_category_det['workout_library_id'], 
                    'category_id' => $workout_category_det['workout_category_id'],
                    'workout_category_librarys_id' =>  $workout_id[$i],
                );

                TeamingWorkout::insert($workoutData);
            }
        }

        return redirect('/athlete/teamingup-group')->with('success','Group Updated Successfully');

    }

    public function createTeamingupGroup()
    { 
     $user = User::where('status', 1)->where('role_id', '!=', 0)->where('id', '!=', Auth()->user()->id)
     ->with('address')->get();

     $workout = WorkoutLibrary::where('status', 1)->orderBy('title', 'ASC')->get();                       
     return view('frontend.athlete.teaming.create-teamingup-group')
     ->with('workout', $workout)
     ->with('user', $user);                         
 }


 public function createTeamingGroupAdd(Request $request){

    // echo "<pre>";
    // echo "fdsg";
    // echo $this->input->post('group_name');
    // echo $request->input('group_name');
    // print_r($request);
    // die;

    // $request->validate([
    //     'group_name' => 'required',
    //     'description' => 'required',
    //     'image' => 'image|mimes:jpg,png,jpeg',
    // ]);
    // $data = $request->only(
    //     'group_name',
    //     'description',
    //     'image'
    // );
    $data['group_name']= $request->input('group_name');
    $data['description']= $request->input('description');

    $data['created_by']= Auth()->user()->id;
    if (request()->hasFile('image')) {
        $file = request()->file('image');
        $fileName = time() . "." . $file->getClientOriginalExtension();
        if($file->move('public/uploads/teaming/coach/', $fileName)){
            $data['image'] = 'public/uploads/teaming/coach/'.$fileName;
        }
    }
    $groupid = Teaming::insertGetId($data);

    $user_id= Auth()->user()->id;
    $creatorDetail = User::where('id', $user_id)       
    ->first();         

    if($groupid){            
        $group_user_id = $request->input('group_user_id');
        
        $group_user_idfin = (rtrim($group_user_id,','));
        $group_user_id = (explode(",",$group_user_idfin));

        $workout_id = $request->input('workout_id');
        
        $workout_idfin = (rtrim($workout_id,','));
        $workout_id = (explode(",",$workout_idfin));

        for($i=0; $i<count($workout_id); $i++){
           $workout_category_det = WorkoutCategoryLibrary::where('id', $workout_id[$i])->first();
           $workoutData= array(
            'teaming_group_id' => $groupid, 
            'workout_id' => $workout_category_det['workout_library_id'], 
            'category_id' => $workout_category_det['workout_category_id'],
            'workout_category_librarys_id' =>  $workout_id[$i],
        );

           TeamingWorkout::insert($workoutData);
       }
       if($group_user_id!=""){

        for($i=0; $i<count($group_user_id); $i++){
            $token = substr(str_shuffle("abcdefghijklmnopqrstABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
            $groupData= array(
                'teaming_group_id' => $groupid, 
                'user_id' => $group_user_id[$i],
                'token' => $token,
                //'is_admin'=>0,
                'is_joined' =>1,
                'status' => 0,                        
            );
            $userEmail= User::select('email')->where('id', $group_user_id[$i])       
            ->first();                 

            /*$email_data= array(
                'creator_name' =>$creatorDetail->username,
                'creator_email' => $creatorDetail->email,
                'token' => $token
            );
            $email= $userEmail->email;*/

            //return view('emails.join-invitation')
            //->with('data', $email_data);
            //Mail::to($email)->send(new TeamInvitationMail($email_data));
            TeamingGroupUser::insert($groupData);

        }
    }
    // echo 1;
    return redirect('/athlete/teamingup-group')->with('success','Group Created Successfully');
}else{
    return back()->with('error', 'Failed to add new group');
    // echo 0;
}
}

    //==Edit Group==

public function editTeamingupGroup(Request $request,$id)
{ 

 $group_detail = Teaming::where('id', $id)->first();

 $group_workout= TeamingWorkout::where('teaming_group_id', $id)->get();
 $workout_group= array();
 if(count($group_workout)>0){
    for($i=0; $i<count($group_workout); $i++){
        array_push($workout_group, $group_workout[$i]->workout_id );
    } 
}

$user = User::where('status', 1)->where('role_id', '!=', 0)->where('id', '!=', Auth()->user()->id)
->with('address')->get();

$workout = WorkoutLibrary::where('status', 1)->orderBy('title', 'ASC')->get();

     $is_search=0;
    $sport_list= Sport::where('status', 1)->get();
    $sport_position= SportPosition::where('status', 1)->get();
    $competition_level= Competition::where('status', 1)->get();
    $city =DB::table('cities')
    ->join('states','states.id', '=', 'cities.state_id')
    ->select('cities.*')
    ->where('states.country_id', 231)
    ->orderBy('cities.name', 'ASC')
    ->get();
    $state= State::where('country_id', 231)->get();

    //filter==
    if(!empty($request->input())){
     $is_search=1;
     $sports = [];
     $states = [];
     $position = [];
     $gender = $request->input('gender');
     $sports = $request->input('sports');
     $position = $request->input('position');
     $start_year = $request->input('start_year');
     $end_year = $request->input('end_year');
     $cities = $request->input('cities');
     $states = $request->input('states');
     $competition = $request->input('competition');
     $graduation_year= $request->input('graduation_year');
     $zip_code = $request->input('zip_code');

     $query = User::whereIn('role_id', [1,2])->where('id','!=', Auth()->user()->id)
     ->with('address');

     $query =User::leftjoin('user_address','user_address.user_id', '=', 'users.id')->leftjoin('user_sport_positions','user_sport_positions.user_id', '=', 'users.id')->leftjoin('user_sports','user_sports.user_id', '=', 'users.id')
     ->select('users.*')
     ->where('users.id','!=', Auth()->user()->id);

     if(!empty($gender)){
        $query = $query->where('gender', $gender);

    }
    if(!empty($sports)){
        $query = $query->whereIn('user_sports.sport_id', $sports);
    }
    if(!empty($position)){
        $query = $query->whereIn('position_id', $position);
    }
    if(!empty($start_year)){
        $query = $query->where('year', '>=', $start_year);
    }
    if(!empty($end_year)){
        $query = $query->where('year', '<=', $end_year);
    }
    if(!empty($cities)){
        $query = $query->where('city_id', $cities);
    }
    if(!empty($states)){
        $query = $query->whereIn('state_id', $states);
    }
    if(!empty($competition)){
        $query = $query->where('competition_id', '=', $competition);
    }
    if(!empty($graduation_year)){
        $query = $query->where('graduation_year',  $graduation_year);
    }

    if(!empty($zip_code)){
        $query = $query->where('user_address.zip', $zip_code);
    }

    $user = $query->groupBy('users.id')->get();
}
/*****End filter*******/                      
return view('frontend.athlete.teaming.edit-teamingup-group')
->with('workout', $workout)
->with('user', $user)
->with('group_detail', $group_detail)
->with('workout_group', $workout_group)
->with('sport_list', $sport_list)
->with('sport_position', $sport_position)
->with('cities', $city)
->with('states', $state)
->with('competition_level', $competition_level)
->with('is_search', $is_search);                        
}

//==Update Group======
public function updateTeamingGroup(Request $request, $id){

    $request->validate([
        'group_name' => 'required',
        'description' => 'required',
        'image' => 'image|mimes:jpg,png,jpeg',
    ]);
    $teaming = Teaming::find( $id );
    $teaming->group_name = $request->input('group_name');
    $teaming->description = $request->input('description');


    if (request()->hasFile('image')) {


        $file = request()->file('image');
        $fileName = time() . "." . $file->getClientOriginalExtension();
        if($file->move('public/uploads/teaming/athlete/', $fileName)){
            $teaming->image= 'public/uploads/teaming/athlete/'.$fileName;
        }
    }
    $teaming->save();

    $user_id= Auth()->user()->id;
    $creatorDetail = User::where('id', $user_id)       
    ->first();         

    $group_user_id = $request->input('group_user_id');

   
    // $workout_id = $request->input('workout_id');

    // if(count($workout_id)>0){
    //     DB::table('teamingup_workout')->where('teaming_group_id', $id)->delete();
    //     for($i=0; $i<count($workout_id); $i++){
    //         $workoutData= array(
    //             'teaming_group_id' => $id, 
    //             'workout_id' => $workout_id[$i],          
    //         );

    //         TeamingWorkout::insert($workoutData);
    //     }
    // }


    /*if($group_user_id!=""){
        DB::table('teamingup_group_users')->where('teaming_group_id', $id)->delete();

        for($i=0; $i<count($group_user_id); $i++){
            $token = substr(str_shuffle("abcdefghijklmnopqrstABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
            $groupData= array(
                'teaming_group_id' => $id, 
                'user_id' => $group_user_id[$i],
                'token' => $token,
                'is_joined' =>1,
                'status' => 0,                        
            );


            TeamingGroupUser::insert($groupData);

        }
    }*/
    
    return redirect('athlete/teamingup-group-details/'.$id.'?group-name='.$teaming->group_name)->with('success','Group Updated Successfully');
/*else{
    return back()->with('error', 'Failed to add new group');
}*/
}



public function searchConnection(Request $request)
{
 $result = DB::table('users')
 ->where('username','LIKE', '%' . $request->text . '%')
 //->where('status', 1)
 ->where('role_id', '!=', 0)
 ->where('id', '!=', Auth()->user()->id)
 ->get();  

 $userArray = array();
 $group_user = TeamingGroupUser::where('teaming_group_id', @$request->group_id)->get();

 foreach ($group_user as $key => $groupUser) {
  array_push($userArray, $groupUser->user_id);
} 
$data= array(
    'res' => $result,
    'userArray' => $userArray

);      
return response()->json($data);
}

public function checkGroup(Request $request){

    $result = DB::table('teamingup_group')->where('group_name', $request->group_name)->count();          
    return response()->json($result);
}


public function inviteMember(Request $request, $group_id){
    $joined_user= array();
    $is_search=0;

    $group_user = TeamingGroupUser::where('teaming_group_id', $group_id)->where('is_joined', 1)->get();
    $teaming_group = Teaming::find($group_id);

    foreach($group_user  as $joined){
        array_push($joined_user, $joined->user_id);
    }
    $user = User::where('status', 1)
    ->where('role_id', '!=', 0)
    ->where('id', '!=', Auth()->user()->id)
                       // ->whereNotIn('id', $joined_user)
    ->with('address')
    ->get();

    
    $sport_list= Sport::where('status', 1)->get();
    $sport_position= SportPosition::where('status', 1)->get();
    $competition_level= Competition::where('status', 1)->get();
    $city =DB::table('cities')
    ->join('states','states.id', '=', 'cities.state_id')
    ->select('cities.*')
    ->where('states.country_id', 231)
    ->orderBy('cities.name', 'ASC')
    ->get();
    $state= State::where('country_id', 231)->get();

    //filter==
    if(!empty($request->input())){
     $is_search=1;
     $sports = [];
     $states = [];
     $position = [];
     $gender = $request->input('gender');
     $sports = $request->input('sports');
     $position = $request->input('position');
     $start_year = $request->input('start_year');
     $end_year = $request->input('end_year');
     $cities = $request->input('cities');
     $states = $request->input('states');
     $competition = $request->input('competition');
     $graduation_year= $request->input('graduation_year');
     $zip_code = $request->input('zip_code');

     $query = User::whereIn('role_id', [1,2])->where('id','!=', Auth()->user()->id)
     ->with('address');

     $query =User::leftjoin('user_address','user_address.user_id', '=', 'users.id')->leftjoin('user_sport_positions','user_sport_positions.user_id', '=', 'users.id')->leftjoin('user_sports','user_sports.user_id', '=', 'users.id')
     ->select('users.*')
     ->where('users.id','!=', Auth()->user()->id);

     if(!empty($gender)){
        $query = $query->where('gender', $gender);

    }
    if(!empty($sports)){
        $query = $query->whereIn('user_sports.sport_id', $sports);
    }
    if(!empty($position)){
        $query = $query->whereIn('position_id', $position);
    }
    if(!empty($start_year)){
        $query = $query->where('year', '>=', $start_year);
    }
    if(!empty($end_year)){
        $query = $query->where('year', '<=', $end_year);
    }
    if(!empty($cities)){
        $query = $query->where('city_id', $cities);
    }
    if(!empty($states)){
        $query = $query->whereIn('state_id', $states);
    }
    if(!empty($competition)){
        $query = $query->where('competition_id', '=', $competition);
    }
    if(!empty($graduation_year)){
        $query = $query->where('graduation_year',  $graduation_year);
    }

    if(!empty($zip_code)){
        $query = $query->where('user_address.zip', $zip_code);
    }

    $user = $query->groupBy('users.id')->get();

}


return view('frontend.athlete.teaming.invite-member')
->with('user', $user)
->with('teaming_group', $teaming_group)
->with('group_id', $group_id)
->with('sport_list', $sport_list)
->with('sport_position', $sport_position)
->with('cities', $city)
->with('states', $state)
->with('competition_level', $competition_level)
->with('is_search', $is_search);
}

public function invite(Request $request){
    $user_id= $request->userId;
    $group_id= $request->group_id;
    $groupDetail = Teaming::where('id', $group_id)       
    ->first(); 

    $creatorDetail = User::where('id', $groupDetail->created_by)       
    ->first(); 

    $token = substr(str_shuffle("abcdefghijklmnopqrstABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
    $groupData= array(
        'teaming_group_id' => $group_id, 
        'user_id' => $user_id,
        'token' => $token,
        'is_joined' =>1,
        'status' => 0,                        
    );
    $userEmail= User::select('email')->where('id', $user_id)       
    ->first();                 

       /* $email_data= array(
            'creator_name' =>$creatorDetail->username,
            'creator_email' => $creatorDetail->email,
            'token' => $token
        );
        $email= $userEmail->email;
        Mail::to($email)->send(new TeamInvitationMail($email_data));*/
        if(TeamingGroupUser::insert($groupData)){
            return 1;
        }else{
            return 0;
        }
    }

    public function deleteMember($id="")
    {      

     $memberId=$id;
     if(DB::table('teamingup_group_users')->delete($memberId)){  
         return response()->json([
            'status' => true,
            'message' => 'Deleted successfully',
        ]);

     }else{
        return back()->with('error', 'Failed to delete member');
    }
}




public function inviteSelectedMember(Request $request){

    $user_id[]= $request->userId;

    $userId_arr= explode(',', $user_id[0]);

    $group_id= $request->group_id;
    $groupDetail = Teaming::where('id', $group_id)       
    ->first(); 

    $creatorDetail = User::where('id', $groupDetail->created_by)       
    ->first(); 

    $token = substr(str_shuffle("abcdefghijklmnopqrstABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
    $userCount= count($userId_arr)-1;
   
    if($userId_arr){
        for($i=0; $i< $userCount; $i++){          
            $groupData= array(
                'teaming_group_id' => $group_id, 
                'user_id' => $userId_arr[$i],
                'token' => $token,
                'is_joined' =>1,
                'status' => 0,                        
            );
            TeamingGroupUser::insert($groupData);

          }
        return 1;
    }else{
        return 0;
    }

}



public function removeSelectedMember(Request $request){

    $user_id[]= $request->userId;

    $userId_arr= explode(',', $user_id[0]);
    $group_id= $request->group_id;
    $groupDetail = Teaming::where('id', $group_id)       
    ->first(); 

    $creatorDetail = User::where('id', $groupDetail->created_by)       
    ->first(); 

    $token = substr(str_shuffle("abcdefghijklmnopqrstABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
    $userCount= count($userId_arr)-1;
 
    if($userId_arr){
        for($i=0; $i< $userCount; $i++){
           DB::table('teamingup_group_users')->where('teaming_group_id', $group_id )->where('user_id', $userId_arr[$i])->delete();

       }
       return 1;
   }else{
    return 0;
}
}


public function deleteGroup($id="")
{      

 $groupId=$id;
 if(DB::table('teamingup_group')->where('id', $groupId )->delete()){ 
     DB::table('teamingup_group_users')->where('teaming_group_id', $groupId )->delete();
     DB::table('teamingup_workout')->where('teaming_group_id', $groupId )->delete();  

     return response()->json([
        'status' => true,
        'message' => 'Deleted successfully',
    ]);

 }else{
    return back()->with('error', 'Failed to delete member');
}
}

public function createGroupAdmin(Request $request){
    $userId= $request->userId;
    $groupId= $request->groupId;
    $action= $request->action;
    if($action=="create"){
       $data= array(
        'teaming_group_id' => $groupId,
        'user_id' => $userId,

    );
       if(TeamingGroupAdmin::insert($data)){
        return response()->json([
            'status' => true,
            'message' => 'Make Group Admin successfully',
        ]);
    }else{
     return back()->with('error', 'Failed to delete member');
 }
}else{
    if(DB::table('teamingup_group_admin')->where('teaming_group_id', $groupId )->where('user_id', $userId )->delete()){
     return response()->json([
        'status' => true,
        'message' => 'Removed from Group Admin',
    ]);


 }else{
     return back()->with('error', 'Failed to delete member');
 }

}


}

public function exitGroup($id="")
{      

 $groupId=$id;
 if(DB::table('teamingup_group_users')->where('teaming_group_id', $groupId )->where('user_id', Auth()->user()->id)->delete()){ 



     return response()->json([
        'status' => true,
        'message' => 'Exited successfully',
    ]);

 }else{
    return back()->with('error', 'Failed to delete member');
}
}


}
