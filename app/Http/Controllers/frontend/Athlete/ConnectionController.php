<?php

namespace App\Http\Controllers\Frontend\Athlete;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Messagechat;
use App\Models\Follower;
use App\Models\Sport;
use App\Models\SportPosition;
use App\Models\Competition;
use App\Models\State;
use App\Models\GuardianInformation;
use App\Models\CoachLevel;
use App\Mail\FollowRequestMail;
use App\Mail\SendRequestMail;
use Illuminate\Support\Facades\Mail;
use Session;
use DB;


class ConnectionController extends Controller
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
    public function index(Request $request, $tabId="")
    {  
        $tab_name="";
        $tab_name= request()->tab;
        
        $tabId=1;               
        $name_search = '';
        $is_search=0;
        $sport= Sport::where('status', 1)->get();
        $sport_position= SportPosition::where('status', 1)->get();
        $competition_level= Competition::where('status', 1)->get();

        $state= State::where('country_id', 231)->get();
        $city =DB::table('cities')
            ->join('states','states.id', '=', 'cities.state_id')
            ->select('cities.*')
            ->where('states.country_id', 231)
             ->orderBy('cities.name', 'ASC')
            ->get();
            //echo count($cities);exit;
       
        $gender="";
        $coaching_level_list= CoachLevel::all();
        
        $following = Follower::where('user_id', Auth()->user()->id)
        ->where('status', 2)
        ->get();

        $follower = Follower::where('follower_id', Auth()->user()->id)
        ->where('status', 2)
        ->get();

        $pending_follower = Follower::where('follower_id', Auth()->user()->id)->whereIn('status', [1, 3])->get();

        $pending_following = Follower::where('user_id', Auth()->user()->id)->whereIn('status', [1, 3])->get();

        if(!empty($request->input('name_search'))){
            $is_search=1;
            $tabId= request()->tabId;
            $name_search = $request->input('name_search');
            $athlete = User::where('role_id', 1)->where('id','!=', Auth()->user()->id)->where('username','LIKE','%'.$name_search.'%')
            ->with('address')
            ->get(); 

            $coach = User::where('role_id', 2)->where('id','!=', Auth()->user()->id)->where('username','LIKE','%'.$name_search.'%')
            ->with('address')
            ->get();            

           
           
        }
        //===Filter===
        elseif(!empty($request->input())){
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

            $query = User::where('role_id', 1)->where('id','!=', Auth()->user()->id)
            ->with('address');

            $query =User::leftjoin('user_address','user_address.user_id', '=', 'users.id')->leftjoin('user_sport_positions','user_sport_positions.user_id', '=', 'users.id')->leftjoin('user_sports','user_sports.user_id', '=', 'users.id')
            ->select('users.*')
            ->where('users.role_id', 1)
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

            $athlete = $query->groupBy('users.id')->get();

            $coach = User::where('role_id', 2)->where('id','!=', Auth()->user()->id)
            ->with('address')
            ->get();            

         }
        //============
        else{
            $athlete = User::where('role_id', 1)->where('id','!=', Auth()->user()->id)
            ->with('address')
            ->get(); 

            $coach = User::where('role_id', 2)->where('id','!=', Auth()->user()->id)
            ->with('address')
            ->get();

           
        }  
        //print_r($sport);exit;                         
        return view('frontend.athlete.connection.index')
        ->with('athlete', $athlete)
        ->with('coach', $coach)
        ->with('following', $following)
        ->with('follower', $follower)
        ->with('name_search', $name_search)
        //->with('sport', $sport)
         ->with('sport_list', $sport)
        ->with('sport_position', $sport_position)
        ->with('competition_level', $competition_level)
        ->with('states', $state)
        ->with('cities', $city)
        ->with('tabId', $tabId)
        ->with('pending_follower', $pending_follower)
        ->with('pending_following', $pending_following)
        ->with('is_search', $is_search)
        ->with('tabId', $tabId)
        ->with('coaching_level_list', $coaching_level_list)
        ->with('tab_name', $tab_name);
    }


    public function addConnectionMessage(Request $request)
    {   
        $request->validate([
            'athleteid' => 'required',
        ]);   
        $data['user_id']    = $request['athleteid'];
        $user_id            = Auth()->user()->id;
        $data['sender_id']  = $user_id;
        $data['status']     = '1';
        $data['firebase_chat_id'] = $user_id.'-'.$request['athleteid'];
        $data['created_at'] = date('Y-m-d H:i:m');
        $data['updated_at'] = date('Y-m-d H:i:m');
        // DB::enableQueryLog();
        // $chat_details  =   DB::select("SELECT * FROM  connection_message WHERE (sender_id = '".$user_id."' OR  user_id = '".$user_id."') AND (sender_id = '".$request['athleteid']."' OR  user_id = '".$request['athleteid']."')  ");
        // $query = DB::getQueryLog();
        // $chat_details  =   DB::select("SELECT * FROM  connection_message WHERE (sender_id = '".$user_id."' OR  user_id = '".$user_id."') AND (sender_id = '".$request['athleteid']."' OR  user_id = '".$request['athleteid']."')  ");
       
        $all_caht_id = DB::table('users_chats_id')->where('user_id', '=', $user_id)->first();
		// echo "<pre>";
        // print_r($all_caht_id);
        
        if(empty($all_caht_id)){
            $values = array('user_id' => Auth()->user()->id,'chat_ids' => $request['athleteid'].',');
            DB::table('users_chats_id')->insert($values);
            // return response()->json([
            //     'success' => true,
            //     'data'=> array('html'=>''),
            //     'message'=>'Chat created Succesfully'
            // ], 200);
        }
        else{
            $all_ids = $all_caht_id->chat_ids;
            // echo $all_ids;
            $all_array =  explode(",", $all_ids);
            // print_r($all_array);
            if (in_array($request['athleteid'], $all_array))
            {
                // echo "Match found";
                // return response()->json([
                //     'success' => true,
                //     'data'=> array('html'=>''),
                //     'message'=>'Chat created Succesfully'
                // ], 200);
                $h = "Match found";
            }
            else
            {
                // echo "Match not found";
                echo $update_value =  $all_caht_id->chat_ids.$request['athleteid'].',';
                DB::table('users_chats_id')
                ->where('id', $all_caht_id->id) 
                ->update(array('chat_ids' => $update_value)); 

                // return response()->json([
                //     'success' => true,
                //     'data'=> array('html'=>''),
                //     'message'=>'Chat created Succesfully'
                // ], 200);
            }

        }

        $all_caht_id1 = DB::table('users_chats_id')->where('user_id', '=', $request['athleteid'])->first();
		// echo "<pre>";
        // print_r($all_caht_id);
        
        if(empty($all_caht_id1)){
            $values = array('user_id' => $request['athleteid'],'chat_ids' =>  $user_id.',');
            DB::table('users_chats_id')->insert($values);
            // return response()->json([
            //     'success' => true,
            //     'data'=> array('html'=>''),
            //     'message'=>'Chat created Succesfully'
            // ], 200);
        }
        else{
            $all_ids = $all_caht_id1->chat_ids;
            // echo $all_ids;
            $all_array =  explode(",", $all_ids);
            // print_r($all_array);
            if (in_array($user_id, $all_array))
            {
                // echo "Match found";
                // return response()->json([
                //     'success' => true,
                //     'data'=> array('html'=>''),
                //     'message'=>'Chat created Succesfully'
                // ], 200);
            }
            else
            {
                // echo "Match not found";
                echo $update_value =  $all_caht_id1->chat_ids.$user_id.',';
                DB::table('users_chats_id')
                ->where('id', $all_caht_id1->id) 
                ->update(array('chat_ids' => $update_value)); 
            }

        }

        return response()->json([
                'success' => true,
                'data'=> array('html'=>''),
                'message'=>'Chat created Succesfully'
            ], 200);

        // die;
        // $addChatIds['user'] = 


        // if (count($chat_details) == 0 ) {
        //    if(Messagechat::insert($data)){  
        //         return response()->json([
        //             'success' => true,
        //             'data'=> array('html'=>''),
        //             'message'=>'Chat created Succesfully'
        //         ], 200);
        //     }else {
        //         return response()->json([
        //             'success' => false,
        //             'data'=> array('html'=>''),
        //             'message'=>'Something went wrong try Again.'
        //         ], 200);
        //     }
        // }else{
        //     return response()->json([
        //             'success' => true,
        //             'data'=> array('html'=>''),
        //             'message'=>'Chat created Succesfully'
        //     ], 200);
        // }
    }

    public function addFollowers(Request $request)
    {
        $user_id= Auth()->user()->id;
            $followId = $request->follower_id;
            

            $follower_detail= User::where('id', $followId)->first();
             $get_year = (date('Y')-12);
             $username= Auth()->user()->username;
             $userbirthYear= Auth()->user()->year;

            $data = $request->only('follower_id');
            $data['user_id'] = $user_id;
            $exit_followers_user = $athlete = Follower::where('status', 1)->where('user_id', $user_id)->where('follower_id', $followId)->first();


             if($follower_detail->year >= $get_year){
                $guardian_detail= GuardianInformation::where('user_id', $followId)->first();
               
                $email_data= array(
                    'username' => $username,

                );
                $email= $guardian_detail->primary_email;

                //return view('emails.follow-request')
                //->with('data', $email_data);
                Mail::to($email)->send(new FollowRequestMail($email_data));
                 if (empty($exit_followers_user)) {
                if(Follower::insert($data)){  
                   return response()->json([
                    'success' => true,
                    'message' => 'Followed'
                ], 200);
                }
            }else{
                 $id=$exit_followers_user->id;
                 if(Follower::find($id)->delete()){
                    return response()->json([
                    'success' => true,
                    'message' => 'Unfollowed'
                ], 200);
                }
                
            }
                

            }
            if($userbirthYear >= $get_year){
                $guardian_detail= GuardianInformation::where('user_id', Auth()->user()->id)->first();

                $email_data= array(
                    'receivername' => $follower_detail->username,

                );
                $email= $guardian_detail->primary_email;

               // return view('emails.send-request')
                //->with('data', $email_data);
                Mail::to($email)->send(new SendRequestMail($email_data));
                 if (empty($exit_followers_user)) {
                if(Follower::insert($data)){  
                   return response()->json([
                    'success' => true,
                    'message' => 'Followed'
                ], 200);
                }
            }else{
                 $id=$exit_followers_user->id;
                 if(Follower::find($id)->delete()){
                    return response()->json([
                    'success' => true,
                    'message' => 'Unfollowed'
                ], 200);
                }
                
            }

            }

            if (empty($exit_followers_user)) {
                if(Follower::insert($data)){  
                   return response()->json([
                    'success' => true,
                    'message' => 'Followed'
                ], 200);
                }
            }else{
                 $id=$exit_followers_user->id;
                 if(Follower::find($id)->delete()){
                    return response()->json([
                    'success' => true,
                    'message' => 'Unfollowed'
                ], 200);
                }
                
            }
    }

    public function searchCoach(Request $request){
    $is_search=1;
    $tabId=2;

    $sport= Sport::where('status', 1)->get();
    $sport_position= SportPosition::where('status', 1)->get();
    $competition_level= Competition::where('status', 1)->get();

    $state= State::where('country_id', 231)->get();
    $city =DB::table('cities')
    ->join('states','states.id', '=', 'cities.state_id')
    ->select('cities.*')
    ->where('states.country_id', 231)
    ->orderBy('cities.name', 'ASC')
    ->get();


    $following = Follower::where('user_id', Auth()->user()->id)
    ->where('status', 2)
    ->get();

    $follower = Follower::where('follower_id', Auth()->user()->id)
    ->where('status', 2)
    ->get();

    $pending_follower = Follower::where('follower_id', Auth()->user()->id)->whereIn('status', [1, 3])->get();

    $pending_following = Follower::where('user_id', Auth()->user()->id)->whereIn('status', [1, 3])->get();
     $coaching_level_list= CoachLevel::all();

    if(!empty($request->input())){

        $is_search=1;
        $coachsports = [];
       
        $gender = $request->input('gender');
        
        $coaching_level = $request->input('coaching_level');
        $coachsports = $request->input('coachsports');
        $primary_age_group = $request->input('primary_age_group');
        $level_name = $request->input('level_name');
        $college_id = $request->input('college_id');


        $query = User::where('role_id', 1)->where('id','!=', Auth()->user()->id)
        ->with('address');

        $query =User::leftjoin('user_address','user_address.user_id', '=', 'users.id')
        ->leftjoin('coach_informations','coach_informations.user_id', '=', 'users.id')
        ->leftjoin('user_sports','user_sports.user_id', '=', 'users.id')
        ->select('users.*')
        ->where('users.role_id', 2)
        ->where('users.id','!=', Auth()->user()->id);

        if(!empty($gender)){
            $query = $query->where('gender_of_coaching', $gender);

        }
        if(!empty($coachsports)){
            $query = $query->whereIn('user_sports.sport_id', $coachsports);
        }
        if(!empty($coaching_level)){
            $query = $query->where('coaching_level', $coaching_level);
        }
        if(!empty($primary_age_group)){
            $query = $query->where('primary_age_group',  $primary_age_group);
        }
        if(!empty($level_name)){
            $query = $query->where('coach_level_name',  $level_name);
        }
        if(!empty($college_id)){
            $query = $query->where('college_id',  $college_id);
        }
        

       $athlete = User::where('role_id', 1)->where('id','!=', Auth()->user()->id)
            ->with('address')
            ->get(); 

            $coach = $query->groupBy('users.id')->get();
           

    }

    return view('frontend.athlete.connection.index')
    ->with('athlete', $athlete)
    ->with('coach', $coach)
    ->with('following', $following)
    ->with('follower', $follower)
    ->with('pending_follower', $pending_follower)
    ->with('pending_following', $pending_following)
    ->with('sport_list', $sport)
    ->with('sport_position', $sport_position)
    ->with('states', $state)
    ->with('cities', $city)
    ->with('competition_level', $competition_level)
    ->with('is_search', $is_search)
    ->with('tabId', $tabId)
    ->with('coaching_level_list', $coaching_level_list);
}

    

}
