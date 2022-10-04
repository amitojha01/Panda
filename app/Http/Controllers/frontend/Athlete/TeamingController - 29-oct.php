<?php

namespace App\Http\Controllers\Frontend\Athlete;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teaming;
use App\Models\User;
use App\Models\WorkoutLibrary;
use App\Models\TeamingWorkout;
use App\Models\TeamingGroupUser;
use App\Mail\TeamInvitationMail;
use Illuminate\Support\Facades\Mail;
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
        ->join('teamingup_group_users','teamingup_group.id', '=', 'teamingup_group_users.teaming_group_id')

        /*->select('teamingup_group.id','teamingup_group.group_name','teamingup_group.description','teamingup_group.image','teamingup_group.created_by','teamingup_group_users.user_id','teamingup_group_users.is_joined')->groupBy('teamingup_group.id')*/

         ->select('teamingup_group.id','teamingup_group.group_name','teamingup_group.description','teamingup_group.image','teamingup_group.created_by','teamingup_group_users.user_id','teamingup_group_users.is_joined')->where('teamingup_group.created_by', $user_id)->orWhere('teamingup_group_users.user_id', $user_id)->groupBy('teamingup_group.id')
        ->get();
        
        return view('frontend.athlete.teaming.index')
        ->with('group', $group);
    }

    public function teamingupGroupDetail($id)
    {                          
        $group_detail = Teaming::where('id', $id)->first();
        $group_user= TeamingGroupUser::where('teaming_group_id', $id)->where('is_joined', 1)->get();
        $creator = User::where('id', $group_detail->created_by)
        ->first();

        $workout= TeamingWorkout::where('teaming_group_id', $id)->get();
        
        return view('frontend.athlete.teaming.teamingup-group-details')
        ->with('group_detail', $group_detail)
        ->with('group_user', $group_user)
        ->with('creator', $creator)
        ->with('workout', $workout);
    }

    public function createTeamingupGroup()
    { 
       $user = User::where('status', 1)->where('role_id', '!=', 0)->where('id', '!=', Auth()->user()->id)
       ->with('address')->get();

       $workout = WorkoutLibrary::where('status', 1)->orderBy('title', 'ASC')->get();                       
       return view('frontend.athlete.teaming.create-teamingup-group')
       ->with('workout', $workout)
       ->with('user', $user);                         
       // return view('frontend.athlete.teaming.create-teamingup-group');
   }


   public function createTeamingGroup(Request $request){
    
    $request->validate([
        'group_name' => 'required',
        'description' => 'required',
        'image' => 'image|mimes:jpg,png,jpeg',
    ]);
    $data = $request->only(
        'group_name',
        'description',
        'image'
    );
    $data['created_by']= Auth()->user()->id;
    if (request()->hasFile('image')) {
        $file = request()->file('image');
        $fileName = time() . "." . $file->getClientOriginalExtension();
        if($file->move('public/uploads/teaming/coach/', $fileName)){
            $data['image'] = 'public/uploads/teaming/coach/'.$fileName;
        }
    }
    $groupid = Teaming::insertGetId($data);

    //return redirect('/athlete/create-teamingup-group')->with('success','Group Created Successfully');

    $user_id= Auth()->user()->id;
    $creatorDetail = User::where('id', $user_id)       
    ->first();         

    if($groupid){            
        $group_user_id = $request->input('group_user_id');
        $workout_id = $request->input('workout_id');           
        for($i=0; $i<count($workout_id); $i++){
         $workoutData= array(
            'teaming_group_id' => $groupid, 
            'workout_id' => $workout_id[$i],          
        );

         TeamingWorkout::insert($workoutData);
     }

     for($i=0; $i<count($group_user_id); $i++){
        $token = substr(str_shuffle("abcdefghijklmnopqrstABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
        $groupData= array(
            'teaming_group_id' => $groupid, 
            'user_id' => $group_user_id[$i],
            'token' => $token,
            //'is_admin'=>0,
            'is_joined' =>0,
            'status' => 0,                        
        );
        $userEmail= User::select('email')->where('id', $group_user_id[$i])       
        ->first();                 

        $email_data= array(
            'creator_name' =>$creatorDetail->username,
            'creator_email' => $creatorDetail->email,
            'token' => $token
        );
        $email= $userEmail->email;

        //return view('emails.join-invitation')
        //->with('data', $email_data);
        Mail::to($email)->send(new TeamInvitationMail($email_data));
        TeamingGroupUser::insert($groupData);

    }
    return redirect('/athlete/teamingup-group')->with('success','Group Created Successfully');
}else{
    return back()->with('error', 'Failed to add new group');
}
}


public function searchConnection(Request $request)
    {
       $result = DB::table('users')
       ->where('username','LIKE', '%' . $request->text . '%')
       ->where('status', 1)
       ->where('role_id', '!=', 0)
       ->where('id', '!=', Auth()->user()->id)
       ->get();        
        return response()->json($result);
    }

    public function checkGroup(Request $request){

        $result = DB::table('teamingup_group')->where('group_name', $request->group_name)->count();          
        return response()->json($result);
    }

    public function inviteMember($group_id){
       $joined_user= array();

       $group_user = TeamingGroupUser::where('teaming_group_id', $group_id)->where('is_joined', 1)->get();
       $teaming_group = Teaming::find($group_id);
       //dd($teaming_group);
       foreach($group_user  as $joined){
        array_push($joined_user, $joined->user_id);

       }
        $user = User::where('status', 1)->where('role_id', '!=', 0)->where('id', '!=', Auth()->user()->id)->whereNotIn('id', $joined_user)
       ->with('address')->get();
      
        return view('frontend.athlete.teaming.invite-member')
        ->with('user', $user)
        ->with('teaming_group', $teaming_group)
        ->with('group_id', $group_id);
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
            'is_joined' =>0,
            'status' => 0,                        
        );
        $userEmail= User::select('email')->where('id', $user_id)       
        ->first();                 

        $email_data= array(
            'creator_name' =>$creatorDetail->username,
            'creator_email' => $creatorDetail->email,
            'token' => $token
        );
        $email= $userEmail->email;
        Mail::to($email)->send(new TeamInvitationMail($email_data));
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

    




}
