<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

use App\Mail\TeamInvitationMail;
use App\Models\Teaming;
use DB;
use App\Models\User;
use App\Models\TeamingWorkout;
use App\Models\TeamingGroupUser;
use App\Models\WorkoutLibrary;

class TeamingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $user = auth('api')->user();
           
            $data =DB::table('teamingup_group')
        ->join('teamingup_group_users','teamingup_group.id', '=', 'teamingup_group_users.teaming_group_id')

         ->select('teamingup_group.id','teamingup_group.group_name','teamingup_group.description','teamingup_group.image','teamingup_group.created_by','teamingup_group_users.user_id','teamingup_group_users.is_joined')->where('teamingup_group.created_by', $user->id)->orWhere('teamingup_group_users.user_id', $user->id)->groupBy('teamingup_group.id')
        ->get();
            return response()->json([
                'success' => true,
                'data'=> $data
            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => true,
                'message' => 'Unable to get request data',
                'data'=> []
            ], 500);
        }
    }

    public function show(Request $request)
    {
        $id = $request->input('group_id');
        try{
            $group_detail = Teaming::where('id', $id)->first();
            //$group_user= TeamingGroupUser::where('teaming_group_id', $id)->where('is_joined', 1)->get();

             $group_user =DB::table('teamingup_group_users')
                            ->leftJoin('users','teamingup_group_users.user_id', '=', 'users.id')
                            ->select('users.id','users.username','users.email','users.profile_image','users.role_id','teamingup_group_users.teaming_group_id')
                            ->where('teamingup_group_users.teaming_group_id', $id)
                            ->where('teamingup_group_users.is_joined', 1) 
                            ->get();
           
            $creator = User::select('id','mobile','email','username','profile_image')->where('id', $group_detail->created_by)
            ->first();            

            $workout= TeamingWorkout::where('teaming_group_id', $id)->get();
            $data= array(
                'group_detail' => $group_detail,
                'group_user' => $group_user,
                'creator' => $creator,
                'workout' => $workout,
            );
            return response()->json([
                'success' => true,
                'data'=> $data
            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => true,
                'message' => 'Unable to get request data',
                'data'=> []
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $data = $request->only('group_name', 'description', 'image');
        $validator = Validator::make($data, [
            'group_name' => 'required',
            'description' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg',
        ]);

        if ($validator->fails()) {
            $err= $validator->errors();
            $err_msg = '';
            foreach(json_decode($err) as $key=> $val){
                $err_msg = $val[0];
                break;
            }
            return response()->json([
                'success' => false,
                'error' => $err_msg
            ], 422);
        }
        try{
            $user = auth('api')->user();
            $data = $request->only(
                'group_name',
                'description',
                'image'
            );
            $data['created_by']= $user->id;
            if (request()->hasFile('image')) {
                $file = request()->file('image');
                $fileName = time() . "." . $file->getClientOriginalExtension();
                if($file->move('public/uploads/teaming/coach/', $fileName)){
                    $data['image'] = 'public/uploads/teaming/coach/'.$fileName;
                }
            }
            $groupid = Teaming::insertGetId($data);
        
            $user_id= $user->id;;
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
                    //$token = substr(str_shuffle("abcdefghijklmnopqrstABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
                    $groupData= array(
                        'teaming_group_id' => $groupid,
                        'user_id' => $group_user_id[$i],
                        'token' => "",
                        //'is_admin'=>0,
                        'is_joined' =>1,
                        'status' => 0,                        
                    );
                    // $userEmail= User::select('email')->where('id', $group_user_id[$i])       
                    //                     ->first();                 
            
                    // $email_data= array(
                    //     'creator_name' =>$creatorDetail->username,
                    //     'creator_email' => $creatorDetail->email,
                    //     'token' => $token
                    // );
                    // $email= $userEmail->email;

                    // Mail::to($email)->send(new TeamInvitationMail($email_data));

                    TeamingGroupUser::insert($groupData);
                }
            }
            return response()->json([
                    'success' => true,
                    'message'=> 'Data successfully saved'
                ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => true,
                'message' => 'Unable to get request data',
                'data'=> []
            ], 500);
        }
    }

    /**
     * Get user list to send invitation
     */
    public function inviteMember(Request $request){
        try{
            $group_id = $request->input('group_id');
            $user = auth('api')->user();
            $group_user = TeamingGroupUser::where('teaming_group_id', $group_id)
                                            ->where('is_joined', 1)
                                            ->get()->pluck('user_id');
            $teaming_group = Teaming::find($group_id);

            $user = User::where('status', 1)
                            ->where('role_id', '!=', 0)
                            ->where('id', '!=', $user->id)
                            ->whereNotIn('id', $group_user)
                            ->with('address')
                            ->get();
            
            return response()->json([
                'success' => true,
                'message'=> '',
                'data'=> array(
                    'user_list'=> $user,
                    'group'=> $teaming_group
                )
            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => true,
                'message' => 'Unable to get request data',
                'data'=> []
            ], 500);
        }
    }
    /*
        ** Invite a single member
    */
    public function invite(Request $request){
        try{
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
                'token' => "",
                'is_joined' =>1,
                'status' => 0,                        
            );
                           
            /**
             * Updated on 05-11-21 as instructed by the AD
             */
            // $userEmail= User::select('email')
            //                 ->where('id', $user_id)       
            //                 ->first();  
            // $email_data= array(
            //     'creator_name' =>$creatorDetail->username,
            //     'creator_email' => $creatorDetail->email,
            //     'token' => $token
            // );
            // $email= $userEmail->email;
            // Mail::to($email)->send(new TeamInvitationMail($email_data));
            TeamingGroupUser::insert($groupData);
            return response()->json([
                'success' => true,
                'message' => 'User added success'
            ]);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => true,
                'message' => 'Unable to get request data',
                'data'=> []
            ], 500);
        }
    }

    public function destroyMember(Request $request)
    {
        $data = $request->only('member_id', 'group_id');
        $validator = Validator::make($data, [
            'member_id' => 'required',
            'group_id' => 'required'
        ]);

        if ($validator->fails()) {
            $err= $validator->errors();
            $err_msg = '';
            foreach(json_decode($err) as $key=> $val){
                $err_msg = $val[0];
                break;
            }
            return response()->json([
                'success' => false,
                'error' => $err_msg
            ], 422);
        }
        try{
            $memberId = $request->input('member_id');
            $groupId = $request->input('group_id');
            TeamingGroupUser::where('user_id', $memberId)
                                ->where('teaming_group_id', $groupId)
                                ->delete();
                return response()->json([
                        'status' => true,
                        'message' => 'Deleted successfully',
                    ]);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => true,
                'message' => 'Unable to get request data',
                'data'=> []
            ], 500);
        }
    }

    /**
     * @request by the self user's
    */
    public function exitGroup(Request $request)
    {
        try{
            $groupId = $request->input('group_id');
            $user = auth('api')->user();
            TeamingGroupUser::where('user_id', $user->id)
                                ->where('teaming_group_id', $groupId)
                                ->delete();
                return response()->json([
                        'status' => true,
                        'message' => 'Exit for the group successfully',
                    ]);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => true,
                'message' => 'Unable to get request data',
                'data'=> []
            ], 500);
        }
    }

    /**
     * @request by the group admin only
     * 
    */
    public function deleteGroup(Request $request)
    {
        try{
            $groupId = $request->input('group_id');
            $user = auth('api')->user();
            $groupAdmin = TeamingGroupUser::where('user_id', $user->id)
                            ->where('teaming_group_id', $groupId)
                            ->where('is_admin', 1)
                            ->first();
            if($groupAdmin){
                Teaming::find( $groupId)->delete();
                return response()->json([
                        'status' => true,
                        'message' => 'Group deleted successfully',
                    ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Unable to authenticated group admin',
            ]);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => true,
                'message' => 'Unable to get request data',
                'data'=> []
            ], 500);
        }
    }
    /**
     * @request by the group admin only
     * 
    */
    public function changeGroupAdmin(Request $request)
    {
        try{
            $groupId = $request->input('group_id');
            $memberId = $request->input('member_id');
            $user = auth('api')->user();
            $groupAdmin = TeamingGroupUser::where('user_id', $user->id)
                            ->where('teaming_group_id', $groupId)
                            ->where('is_admin', 1)
                            ->first();
            if($groupAdmin){
                TeamingGroupUser::where('user_id', $memberId)
                                ->where('teaming_group_id', $groupId)
                                ->update(['is_admin'=> 1]);

                return response()->json([
                        'status' => true,
                        'message' => 'Admin changed successfully',
                    ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Unable to authenticated group admin',
            ]);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => true,
                'message' => 'Unable to get request data',
                'data'=> []
            ], 500);
        }
    }
    
}
