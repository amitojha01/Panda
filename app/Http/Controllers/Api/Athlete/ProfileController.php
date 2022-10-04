<?php

namespace App\Http\Controllers\Api\Athlete;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use App\Models\VideoEvidence;
use App\Models\VideoEvidenceLike;
use App\Models\WorkoutCategory;
use App\Models\WorkoutLibrary;
use App\Models\State;
use App\Models\Follower;

use App\Models\UserAddress;
use App\Models\Gamehighlight;
use App\Models\Education;

use App\Models\Teaming;

use App\Models\UserSport;
use App\Models\Compare;
use App\Models\CompareGroup;
use App\Models\UserAciIndex;

use App\Models\UserSportPosition;
use App\Models\Sport;
use App\Models\SportPosition;

use App\Models\UserCollege;
use App\Models\User;
use App\Models\UserWorkoutLibrary;
use App\Models\UserWorkoutExercises;
use App\Models\UserPhysicalInformation;

use App\Models\WorkoutLibraryMeasurement;


use App\Models\UserAciIndexLog;
use DB;
use URL;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //    echo URL::to('dev2/Panda/dev/api/dashboard-graph-api/10'); die;
        // https://dev.fitser.com/dev2/Panda/dev/api/dashboard-graph-api/10
        // echo base_url().'Panda/dev/api/dashboard-graph-api/10'; die;
        $user_id = $request->input('user_id');
        try{
            // $user_id= Auth()->user()->id;
            $user = User::where('id', $user_id)        
             ->with('physicalInfo')
             ->with('address')      
             ->first();

            $user_details = array();
            $user_details['id'] = !empty($user->id) ? $user->id  : 0 ;
            $user_details['role_id'] = ($user->role_id == 1) ? 'Athlete' : 'Coach' ;
            $user_details['username'] = !empty($user->username) ? $user->username : '' ;
            $user_details['mobile'] = !empty($user->mobile) ? $user->mobile  : '' ;
            $user_details['email'] = !empty($user->email) ? $user->email  : '' ;
            $user_details['password'] = !empty($user->password) ? $user->password  : '' ;
            $user_details['gender'] = !empty($user->gender) ? $user->gender  : '' ;
            $user_details['year'] = !empty($user->year) ? $user->year  : 0 ;
            $user_details['month'] = !empty($user->month) ? $user->month  : 0 ;
            $user_details['day'] = !empty($user->day) ? $user->day  : 0 ;
            $user_details['graduation_year'] = !empty($user->graduation_year) ? $user->graduation_year  : '' ;
            $user_details['profile_type'] = !empty($user->profile_type) ? $user->profile_type : 0  ;
            $user_details['profile_image'] = !empty($user->profile_image) ? $user->profile_image  : '' ;
            $user_details['status'] = !empty($user->status) ? $user->status  : 0 ;
            

            $user_state =DB::table('user_address')
            ->join('states','states.id', '=', 'user_address.state_id')
            ->join('cities','cities.id', '=', 'user_address.city_id')
            ->select('user_address.*','states.name as stateName','cities.name as citiesName')
            ->where('user_address.user_id', $user_id )
            ->first();
            
            // echo "<pre>";
            // print_r($user_state);
            // die;
            
            $user_details['city_id'] = !empty($user_state->city_id) ? $user_state->city_id  : '' ;
            $user_details['cities_name'] = !empty($user_state->citiesName) ? $user_state->citiesName  : '' ;
            $user_details['state_id'] = !empty($user_state->state_id) ? $user_state->state_id  : '' ;
            $user_details['state_name'] = !empty($user_state->stateName) ? $user_state->stateName  : '' ;
            $user_details['zip'] = !empty($user_state->zip) ? $user_state->zip  : '' ;

            $user_sicalInformation = array();
            $user_physical = UserPhysicalInformation::where('user_id', $user_id)->first();
            $user_sicalInformation['id'] = !empty($user_physical->id) ? $user_physical->id : 0  ;  
            $user_sicalInformation['height_feet'] = !empty($user_physical->height_feet) ? $user_physical->height_feet : 0  ; 
            $user_sicalInformation['height_inch'] = !empty($user_physical->height_inch) ? $user_physical->height_inch : 0  ; 
            $user_sicalInformation['weight'] = !empty($user_physical->weight) ? $user_physical->weight : 0  ;
            $user_sicalInformation['wingspan_feet'] = !empty($user_physical->wingspan_feet) ? $user_physical->wingspan_feet : 0  ; 
            $user_sicalInformation['wingspan_inch'] = !empty($user_physical->wingspan_inch) ? $user_physical->wingspan_inch : 0  ;
            $user_sicalInformation['head'] = !empty($user_physical->head) ? $user_physical->head : 0  ;
            $user_sicalInformation['dominant_hand'] = !empty($user_physical->dominant_hand) ? $user_physical->dominant_hand : ''  ; 
            $user_sicalInformation['dominant_foot'] = !empty($user_physical->dominant_foot) ? $user_physical->dominant_foot : ''  ; 
            
            
            // echo "<pre>";
            // print_r($user_physical);
            // die;
            $user_sports = UserSportPosition::where('user_id', $user_id)->get();
            // echo "<pre>";
            // print_r($user_sports);
            // die;
            $user_sports_details =array();
            if(count($user_sports) > 0){
                foreach($user_sports as $key => $user_sports_val){

                $sport_name = Sport::where('id',  $user_sports_val['sport_id'])->first();
                $sportPosition_name = SportPosition::where('id',  $user_sports_val['position_id'])->first();
     
                $temp['sport_id'] = !empty($sport_name['id']) ? $sport_name['id'] : 0  ;
                $temp['sport_name'] = !empty($sport_name['name']) ? $sport_name['name'] : ''  ;
                
                $temp['sport_position_id'] = !empty($sportPosition_name['id']) ? $sportPosition_name['id'] : 0  ;
                $temp['sport_position_name'] = !empty($sportPosition_name['name']) ? $sportPosition_name['name'] : ''  ;
                
                $user_sports_details[] = $temp;
                
                }
            }
            // print_r($user_sports_details);
            //         die;
           

            $follower = Follower::where('follower_id', $user_id)->get();
            $following = Follower::where('user_id', $user_id)->get();

            $total_follower = count($follower);
            $total_following = count($following);
            $user_details['follower'] = !empty($total_follower) ? $total_follower : 0;
            $user_details['following'] = !empty($total_following) ? $total_following : 0;
            
            

            // print_r($user->email);
            $user_aci_rank = $this->aciRankCalculate($user->id);
            // print_r($user_aci_rank);
            // sports
            $user_sport =DB::table('user_sports')
            ->join('sports','sports.id', '=', 'user_sports.sport_id')
            // ->join('cities','cities.id', '=', 'user_address.city_id')
            ->select('user_sports.*','sports.name as sportsName')
            ->where('user_sports.user_id', $user_id )
            ->get();
            // echo "<pre>";
            // print_r($user_sport);
            // die;


            $workout_library = UserWorkoutLibrary::where('user_id', $user->id)->where('status', 1)->get();
            // echo "<pre>";
            // print_r($workout_library);
            // die;
            // dd($workout_library);
            // die;

            $workout_librarys =array();
            if(count($workout_library) > 0){
                foreach($workout_library as $key => $val){
                    $temp_all_value = WorkoutLibrary::where('status', 1)->where('id', $val->workout_library_id)->first();
                    // print_r($temp_all_value);
                    // die;
                    if(!empty($temp_all_value)){
                    $temp_WorkoutExercises = UserWorkoutExercises::where([
                        'workout_library_id'=> $temp_all_value->id,
                        'user_id'=> $user->id
                        ])->first();
                        // print_r($temp_WorkoutExercises);
                        // die;
                        
                    }
                    $temp['workout_library_id'] = !empty($val->workout_library_id) ? $val->workout_library_id : '';
                    $temp['title'] = !empty($temp_all_value->title) ? $temp_all_value->title : '';
                    $temp['description'] = !empty($temp_all_value->description) ? $temp_all_value->description : '';

                    $temp['record_date'] = !empty($temp_WorkoutExercises->record_date) ? $temp_WorkoutExercises->record_date : '';
                    $temp['unit_1'] = !empty($temp_WorkoutExercises->unit_1)  ? $temp_WorkoutExercises->unit_1 : '';
                    $temp['unit_2'] = !empty($temp_WorkoutExercises->unit_2) ? $temp_WorkoutExercises->unit_2 : '';
                    
                    if($temp_all_value){
                        //print_r($temp);
                        $cat = WorkoutCategory::where('status', 1)->where('id', $val->workout_id)->first();
                        //print_r($temp);
                        $measurement = WorkoutLibraryMeasurement::where('id', $temp_all_value->measurement_id)
                        ->select('name', 'unit')
                        ->first();
                        $temp['category_title'] =  !empty($cat->category_title)? $cat->category_title : '' ;
                        $temp['category_id'] =  !empty($cat->id)? $cat->id : '';
                        $temp['measurement'] =  !empty($measurement) ? $measurement : []; 
                    }
                    $workout_librarys[] = $temp;
                }
            }
            else{
                $workout_librarys = array();

            }
            // print_r($workout_librarys);
            // die;

            $video_evidence = VideoEvidence::where('status', 1)->get();
            $all_video_evidence = array();
            $total_video_evidence = array();
        
            if(count($video_evidence) != ''){
                foreach ($video_evidence as $video_evidence_value) {
                    $video_evidence_like = VideoEvidenceLike::where('video_evidence_id', $video_evidence_value->id)->where('status', 1)->get();
                    // echo count($game_highlight); die;
                    $all_video_evidence['id'] = $video_evidence_value->id;
                    $all_video_evidence['user_id'] = $video_evidence_value->user_id;
                    $all_video_evidence['date_of_video'] = $video_evidence_value->date_of_video;
                    $all_video_evidence['workout_category_id'] = $video_evidence_value->workout_category_id;
                    $all_video_evidence['workout_type_id'] = $video_evidence_value->workout_type_id;
                    $all_video_evidence['video_link'] = $video_evidence_value->video_link;
                    $all_video_evidence['video_embeded_link'] = $video_evidence_value->video_embeded_link;
                    $all_video_evidence['status'] = $video_evidence_value->status;
                    $all_video_evidence['total_like'] = count($video_evidence_like);

                    $total_video_evidence[] = $all_video_evidence;
                }
            }
            else{
                $total_video_evidence = array();

            }

            $game_highlight = Gamehighlight::where('status', 1)->get();
            $all_game_highlight = array();
            $total_game_highlight = array();
        
            if(count($game_highlight) != ''){
                foreach ($game_highlight as $game_highlight_value) {
                    
                    $all_game_highlight['id'] = $game_highlight_value->id;
                    $all_game_highlight['user_id'] = $game_highlight_value->user_id;
                    $all_game_highlight['record_date'] = $game_highlight_value->record_date;
                    $all_game_highlight['description'] = $game_highlight_value->description;
                    $all_game_highlight['video'] = $game_highlight_value->video;
                    $all_game_highlight['status'] = $game_highlight_value->status;

                    $total_game_highlight[] = $all_game_highlight;
                }
            }
            else{
                $total_game_highlight = array();
            }

        
            $all_athlete_flower =DB::table('followers')
            ->join('users','users.id', '=', 'followers.follower_id')
            ->select('users.*')
            ->where('followers.user_id', $user_id )
            ->where('users.role_id',  '1')
            ->where('users.status','!=', 0)
            ->where('followers.status', 1)
            ->get();

            // $athlete_flower_user = array();
            // if(count($all_athlete_flower) != ''){
            //     foreach ($all_athlete_flower as $athlete_flower) {

            //         $athlete_flower_user['id'] = $athlete_flower->id ;
            //         $athlete_flower_user['role_id'] = $athlete_flower->role_id ;
            //         $athlete_flower_user['username'] = $athlete_flower->username ;
            //         $athlete_flower_user['email'] = $athlete_flower->email ;
            //         $athlete_flower_user['gender'] = $athlete_flower->gender ;
            //         $athlete_flower_user['profile_type'] = $athlete_flower->profile_type ;
            //         $athlete_flower_user['profile_image'] = $athlete_flower->profile_image ;
            //         $all_athlete_flower_user[] = $athlete_flower_user;
            //     }
            // }
            // else{
            //     $all_athlete_flower_user = array();

            // }


            // $all_coaches_flower =DB::table('followers')
            // ->join('users','users.id', '=', 'followers.follower_id')
            // ->select('users.*')
            // ->where('followers.user_id', $user_id )
            // ->where('users.role_id',  '2')
            // ->where('users.status','!=', 0)
            // ->where('followers.status', 1)
            // ->get();
            // // print_r($all_coaches_flower); 

            // $coaches_flower_user = array();
            // if(count($all_coaches_flower) != ''){
            //     // echo 'fdef'; die;
            //     foreach ($all_coaches_flower as $coaches_flower) {

            //         $coaches_flower_user['id'] = $coaches_flower->id ;
            //         $coaches_flower_user['role_id'] = $coaches_flower->role_id ;
            //         $coaches_flower_user['username'] = $coaches_flower->username ;
            //         $coaches_flower_user['email'] = $coaches_flower->email ;
            //         $coaches_flower_user['gender'] = $coaches_flower->gender ;
            //         $coaches_flower_user['profile_type'] = $coaches_flower->profile_type ;
            //         $coaches_flower_user['profile_image'] = $coaches_flower->profile_image ;
            //         $all_coaches_flower_user[] = $coaches_flower_user;
            //     }
                
            // }
            // else{
            //     $all_coaches_flower_user = array();
            // }
        
            // $data =DB::table('')
            $teamingup_group_val =DB::table('teamingup_group')
            ->select('*')
            ->where('created_by', $user_id )
            ->where('status', 1)
            ->get();

            $teamingup_group = array();
            if($teamingup_group_val){
                foreach ($teamingup_group_val as $teamingup_group_value) {
                    $teamingup_group['id'] = $teamingup_group_value->id  ;
                    $teamingup_group['group_name'] = $teamingup_group_value->group_name  ;
                    $teamingup_group['description'] = $teamingup_group_value->description  ;
                    $teamingup_group['image'] = $teamingup_group_value->image  ; 
                    $teamingup_group['status'] = $teamingup_group_value->status  ;

                    $all_teamingup_group[] = $teamingup_group;
                }
            }
            else{
                $all_teamingup_group = array();
            }


        // print_r($teamingup_group);
        // die;
            $data = array();
            $data['user_id'] = $user->id;
            $data['user_details'] = $user_details;
            $data['user_sicalInformation'] = $user_sicalInformation;
            $data['user_sports_details'] = $user_sports_details;
            
            
            $data['user_aci_rank'] = $user_aci_rank;
            $data['workout_librarys'] = $workout_librarys;
            $data['graph-api'] = URL::to('api/dashboard-graph-api/'.$user_id);
            $data['total_video_evidence'] = $total_video_evidence;
            $data['total_game_highlight'] = $total_game_highlight;
            // $data['all_athlete_flower_user'] = $all_athlete_flower_user;
            // $data['all_coaches_flower_user'] = $all_coaches_flower_user;
            $data['all_teamingup_group'] = $all_teamingup_group;
        
            // print_r($data);
        
            return response()->json([
                'success' => true,
                'data'=> $data
            ], 200);
        }

        catch(\Exception $e){
            return response()->json([
                'success' => true,
                'message' => 'Unable to get request data',
                'data'=> []
            ], 500);
        }

    }

    public function aciRankCalculate($user_id)
    {
        //     echo $user_id; die;
        $user_id = $user_id;
        $user_detail=  User::where('id', $user_id)->first();
     
        $user_index_rank =DB::table('user_aci_indexs')
        ->select('user_aci_indexs.aci_index')
        ->where('user_id', $user_id )
        ->first();

        //   echo $user_index_rank->aci_index;

        if(!empty($user_index_rank)){
  
            $all_user_workout_list =DB::table('user_aci_indexs')
            ->join('users','user_aci_indexs.user_id', '=', 'users.id')
                ->select('user_aci_indexs.aci_index')
                ->where('users.gender', $user_detail->gender )
                ->where('users.year',  $user_detail->year)
                ->where('users.status','!=', 0)
                ->orderBy('user_aci_indexs.aci_index', 'desc')
            ->get();

            $total_aci_index = array();
            foreach ($all_user_workout_list as $row) {
            $total_aci_index[] = $row->aci_index;
        }

        $total_user = count($all_user_workout_list);

            $my_index = array_search($user_index_rank->aci_index,$total_aci_index,true);
            $my_index = $my_index+1;
            // echo $total_user; die;
            $all_result = (($total_user - $my_index ) / $total_user)*100;
            $aci_data = array();
            $aci_data['athletic_competency_index_score']= $user_index_rank->aci_index;
            $aci_data['aci_rank']= $all_result;
            return $aci_data;
            }
            else{
            $aci_data['athletic_competency_index_score']= 0;
            $aci_data['aci_rank']= 0;
            return $aci_data;
            }
            
    }

    // for web view only show graph --------------------------
    public function dashboardGraphApi($user_id)
    {
        $all_aci_score = UserAciIndexLog::where('user_id', $user_id)->get();
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

        return view('frontend.athlete.dashboard.graph')   
                ->with('score_dataset', $score_dataset);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'date_of_video' => 'required',
            'workout_category_id' => 'required',
            'workout_type_id' => 'required',
            // 'video_link' => 'required',
            'status' => 'required',
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
            $videoLink = $request->video_link;
           $rx = '~^(?:https?://)?(?:www[.])?(?:youtube[.]com/watch[?]v=|youtu[.]be/)([^&]{11})~x';
            $has_match = preg_match($rx, $videoLink, $matches);
            $videoId = $matches[1];
            $user_id= auth('api')->user()->id;
            
            $data = $request->only('date_of_video', 'workout_category_id', 'workout_type_id', 'video_link', 'status');
            // dd($user->id);
            $data['video_embeded_link'] =  'https://www.youtube.com/embed/'.$videoId.'?autoplay=0';
            $data['user_id'] = $user_id;
            
            VideoEvidence::insert($data);

            return response()->json([
                                'success' => true,
                                'message' => "Video Evidence saved successfully."
                            ], 200);
        }
        catch(\Exception $e)
        {
            dd($e);
            return response()->json([
                'success' => false,
                'message' => "Failed to saved data."
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->input('video_evidence_id');
        try{
            $data = VideoEvidence::find($id);
            $data->workout_category_name = '';
            $data->workout_type_name = '';
            if($data){
                $xx = WorkoutCategory::find($data->workout_category_id);
                if($xx ){
                    $data->workout_category_name = $xx->category_title;
                }
                 $yy = WorkoutLibrary::find($data->workout_type_id);
                if($yy ){
                    $data->workout_type_name = $yy->title;
                }
            }
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
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
           'date_of_video' => 'required',
            'workout_category_id' => 'required',
            'workout_type_id' => 'required',
            'video_link' => 'required',
            'status' => 'required',
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
            $id = $request->input('video_evidence_id');
            //for embedded video link
            $videoLink = $request->video_link;
            $rx = '~^(?:https?://)?(?:www[.])?(?:youtube[.]com/watch[?]v=|youtu[.]be/)([^&]{11})~x';
            $has_match = preg_match($rx, $videoLink, $matches);
            $videoId = $matches[1];

            $user_id= auth('api')->user()->id;
            $data = $request->only('date_of_video', 'workout_category_id', 'workout_type_id', 'video_link','status');
             $data['video_embeded_link'] =  'https://www.youtube.com/embed/'.$videoId.'?autoplay=0';
            $data['user_id'] = $user_id;
            VideoEvidence::where('id', $id)->update($data);

            return response()->json([
                                'success' => true,
                                'message' => "Video Evidence update successfully."
                            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to update data."
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->input('video_evidence_id');
        if(VideoEvidence::where('id', $id)->update(['status'=>3])){
            return response()->json([
                    'success' => true,
                    'message'=>'Data Deleted Succesfully'
                ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => "Failed to delete data."
            ], 500);
        }
    }

    public function addFollowApi(Request $request)
    {
        $user_id = $request->input('user_id');

        $followId = $request->input('follower_id');
        $data['follower_id'] = $request->input('follower_id');
        $data['user_id'] = $user_id;
        $exit_followers_user = $athlete = Follower::where('status', 1)->where('user_id', $user_id)->where('follower_id', $followId)->first();
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

    public function groupListApi(Request $request)
    {   
        try{
        $user_id = $request->input('user_id');
        $comparison_group = DB::table('compare_group')
        ->leftjoin('compare','compare_group.id', '=', 'compare.comparison_group_id')
        ->select('compare_group.id','compare_group.comparison_name')->where('compare_group.status', 1)->where('compare.status', 1)->where('compare.user_id', $user_id)->groupBy('compare_group.id')
        ->get();

        $temp_f = array();

        foreach($comparison_group as $groupvalue){
           $temp['id'] = $groupvalue->id;
           $temp['comparison_name'] = $groupvalue->comparison_name;
           $temp_f[] = $temp;
        }

            return response()->json([
                'success' => true,
                'data' => $temp_f
            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
            'success' => false,
            'message' => "Failed."
            ], 500);
        }
    }
    
    public function groupAthleteCompareDetailsApi(Request $request)
    {
        
       $group_id = $request->input('group_id');
       $user_id = $request->input('user_id');

       $workout_library = UserWorkoutLibrary::where('user_id', $user_id)->where('status', 1)->where('workout_id', 8)->get(); // only aci  
     
      $workout_librarys = [];
      
        $temp = [];
        $temp['category_title'] =  'ACI(TM) workouts';
        $temp['title'] = '% Rank';
        $temp['category_id'] =  0;
        $temp['workout_id'] = 0;
        $workout_librarys [] = $temp;

        $temp['category_title'] =  'ACI(TM) workouts';
        $temp['title'] = 'Aci Index';
        $temp['category_id'] =  0;
        $temp['workout_id'] = 0;
        $workout_librarys [] = $temp;

        if(count($workout_library) > 0){
            foreach($workout_library as $key => $val){
                $temp1 = WorkoutLibrary::where('status', 1)->where('id', $val->workout_library_id)->first();
                //   print_r($temp1); die;
                if($temp1){
                    $cat = WorkoutCategory::where('status', 1)->where('id', $val->workout_id)->first();
                  
                    $temp['category_title'] =  $cat->category_title;
                    $temp['title'] =  $temp1->title;
                    $temp['category_id'] =  $cat->id;
                     $temp['workout_id'] = $val->workout_library_id;
                    $workout_librarys[] = $temp;
                    $arr[] =  $val->workout_library_id;


                }
            }
        }

        // $compare_value = [];
        // $com_temp = [];
        // if(count($arr) > 0){
        //     foreach($arr as $key => $workout_library_id_val){
        //         $com_temp []
        //     }
        // }

        $comparisonId = $group_id;
        $compare_with = Compare::where('user_id', $user_id)->where('status', 1)->where('comparison_group_id', $comparisonId)->get();
        $compare_withs = [];
        $temp_self = User::where('role_id', 1)->where('id', $user_id)
        ->first();
        $user_aci = UserAciIndex::where('status', 1)->where('user_id', $user_id)
        ->first();
        $temp_self['aci_index'] =  $user_aci ? $user_aci->aci_index : 0;
        foreach ($compare_with as $key => $value) {
            $temp_user = User::where('id', $value->compare_user_id)
            ->first();

            $user_aci = UserAciIndex::where('status', 1)->where('user_id', $value->compare_user_id)
            ->first();

             $temp_user['compare_id'] =  $value->id;
             $temp_user['aci_index'] =  $user_aci ? $user_aci->aci_index : 0;

            $compare_withs[] = $temp_user;
         }
         $compare_withs[] = $temp_self;

         
		$compare_array = collect($compare_withs)->sortBy('aci_index')->reverse()->toArray();

        if(count($compare_array) > 0){
            $compare_value_user = [];
            $temp_value = [];
            $rank=1;
            $pos=1;
            foreach($compare_array as $key => $compare_list){
            $newpos = $pos++;
            $per = ($newpos == 1) ? ((1*1)*99) : ((1-($newpos/count($compare_array)))*100);
                $temp_user = UserWorkoutExercises::where('status', 1)->where('user_id', $compare_list['id'])->whereIn('workout_library_id', $arr)->get();
                $temp_value['profile_image'] =  isset($compare_list["profile_image"])? asset($compare_list["profile_image"]) : asset("public/frontend/athlete/images/defaultuser.jpg") ;   
                $temp_value['username'] = $compare_list["username"];
                if(count($temp_user) > 0){
                    $tmpArr =array();
                   
                    foreach($temp_user as $tu){
                        $tmpArr[$tu->workout_library_id]	= $tu;
                    }
                    
                   
                    $temp_value['Rank'] = $rank++ ;
                    $temp_value['% Rank'] = round($per);
                    if(!empty($arr)){
                        foreach($arr as $a){
                            $temp1 = WorkoutLibrary::where('status', 1)->where('id', $a)->first();
                            // print_r($temp1); die;
                            $temp_value[$temp1->title] = ((array_key_exists($a, $tmpArr)) ?  $tmpArr[$a]['unit_1'] : '0') ;
                        }
                    }
                    else{
                        foreach($arr as $a){
                            
                        $temp1 = WorkoutLibrary::where('status', 1)->where('id', $a)->first();
                          $temp_value[$temp1->title] =  0;
                        }
                    }
                }
                
                $compare_value_user[] = $temp_value;
        
            }
        }
        // print_r($compare_value_user);
        // die;
        // echo "<pre>";
        // print_r($workout_librarys);
        // print_r($arr);
        // die;

        return response()->json([
            'success' => true,
            'message' => 'Compare list',
            'workout_librarys' => $workout_librarys,
            'compare_user_value' => $compare_value_user,
        ], 200);

    }

    public function addGroupApi(Request $request)
    {
        $user_id = $request->input('user_id');
        $comparison_name = $request->input('comparison_name');
        // $group_user_id = $request->input('compare_grp');

        // echo "<pre>";
        
        // print_r($group_user_id);
        // foreach(json_decode($group_user_id) as $grp_user_id){
        //     echo ($grp_user_id);
        // }
        // die;
        $data['comparison_name'] = $comparison_name;
        $data['created_by']= $user_id;
        
        $group_user_id = json_decode($request->input('compare_grp'));
        if($group_user_id){
        $groupid = CompareGroup::insertGetId($data);

            if($groupid){            
                $group_user_id = json_decode($request->input('compare_grp'));
            
            

                for($i=0; $i<count($group_user_id); $i++){
                $groupData= array(
                    'comparison_group_id' => $groupid, 
                    'user_id' =>  $user_id, 
                    'compare_user_id' => $group_user_id[$i],                        
                );
            

                Compare::insert($groupData);

                }

                return response()->json([
                    'success' => true,
                    'message' => 'Comparison added'
                ], 200);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Failed'
                ], 200);
            }
        }
        else{
        return response()->json([
            'success' => false,
            'message' => 'Failed'
        ], 200);
        }

    }

    

    public function createGroupComparison(Request $request)
    {
        
        $user_id = $request->input('user_id');
        $comparison_name = $request->input('group_comparison_name');
        $data['comparison_name'] = $comparison_name;
    
        $data['created_by']= $request->input('user_id');

        $groupid = CompareGroup::insertGetId($data);

        if($groupid){            
            $group_user_id = json_decode($request->input('group_compare'));
        }

        $group_detail = Teaming::whereIn('id',$group_user_id)->get();
        
            $groupmember =DB::table('teamingup_group_users')
        ->leftjoin('users','teamingup_group_users.user_id', '=', 'users.id')

            ->select('users.id')->whereIn('teamingup_group_users.teaming_group_id',$group_user_id)->Where('users.status', 1)->Where('users.role_id', 1)->Where('users.id','!=', $user_id)->groupBy('teamingup_group_users.user_id')
        ->get();
        if($groupmember!=""){

            for($i=0; $i<count($groupmember); $i++){
            $groupData= array(
                'comparison_group_id' => $groupid, 
                'user_id' => $user_id, 
                'compare_user_id' => $groupmember[$i]->id,                        
            );
            Compare::insert($groupData);

            }
        }
        return response()->json([
                'success' => true,
                'message' => 'Comparison added'
            ], 200);
        


    }

        
    public function deleteCompare(Request $request)
    {
        $user_id= $request->input('user_id');
        $compareId= $request->input('compareId');

        $comparison_group_id = Compare::where('comparison_group_id', $compareId)->get();
        if ($comparison_group_id) {
            foreach ($comparison_group_id as $key => $value) {
                Compare::where('id',$value->id)->delete();
            }
        }
        
        if(CompareGroup::where('id',$compareId)->delete()){            
            // return redirect('/athlete/events')->with('success','Events Deleted Successfully');
            return response()->json([
                'success' => true,
                'data'=> 'compare',
                'message'=>'Deleted Succesfully'
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'data'=> 'compare',
                'message'=>'Failed to delete event'
            ], 200);
        }
    }

    public function personalUpdateProfile(Request $request)
    {
        
            $id = $request->input('user_id');
            $user = User::find( $id );
        if($user != ''){     
            $user->username = $request->input('username') ? $request->input('username') : '';
            $user->mobile = $request->input('mobile') ? $request->input('mobile') : '';
            // $user->email = $request->input('email') ? $request->input('email') : '';
            $user->gender = $request->input('gender') ? $request->input('gender') : ''; 
            $user->profile_type = $request->input('profile_type') ? $request->input('profile_type') : '';
            $user->contact_email = $request->input('contact_email') ? $request->input('contact_email') : '';

            $user->day = $request->input('day') ? $request->input('day') : '';
            $user->month = $request->input('month') ?  $request->input('month') : '';        
            $user->year = $request->input('year') ? $request->input('year') : ''; 
            // $user->publish_contact = $request->input('publish_contact') ? $request->input('publish_contact') : ''; 
            $user->graduation_year = $request->input('graduation_year') ? $request->input('graduation_year') : '';      

            if (request()->hasFile('profile_image')) {
                $file = request()->file('profile_image');
                $fileName = time() . "." . $file->getClientOriginalExtension();
                if($file->move('public/uploads/profile/', $fileName)){
                    $user->profile_image = 'public/uploads/profile/'.$fileName;
                }
            }
            $user->save();

            return response()->json([
                'success' => true,
                'data'=> 'Profile',
                'message'=>'Update Succesfully'
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'data'=> 'Profile',
                'message'=>'faild'
            ], 200);
        }
    }
    
    public function personalUpdateAddress(Request $request)
    {

        $user_id = $request->input('user_id');
        if($user_id != ''){
            $addressInfo = UserAddress::where('user_id', $user_id)
            ->first();
            if($addressInfo != ''){
                $addressInfo->country_id = $request->input('country_id');
                $addressInfo->state_id = $request->input('state_id');
                $addressInfo->city_id = $request->input('city_id'); 
                $addressInfo->zip = $request->input('zip'); 
                
                $addressInfo->save();

            }else{
                

                $addressData= array(
                    'country_id' => $request->input('country_id'), 
                    'state_id' => $request->input('state_id'), 
                    'city_id' => $request->input('city_id'),
                    'zip' =>  $request->input('zip'),               
                );
                $addressData['user_id'] = $user_id;

                UserAddress::insert($addressData);

            }
            return response()->json([
                'success' => true,
                'data'=> 'Profile',
                'message'=>'Update Successfully'
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'data'=> 'Profile',
                'message'=>'faild'
            ], 200);
        }

    }
    
    public function personalUpdatePhysicalInfo(Request $request)
    {
        $user_id = $request->input('user_id');
        if($user_id != ''){
            $physicalInfo = UserPhysicalInformation::where('user_id', $user_id)->first();

            if($physicalInfo != ''){
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

            }else{

                $physicalInfoData= array( 
                'height_feet' => $request->input('height_feet'),
                'height_inch' => $request->input('height_inch'),
                'weight' => $request->input('weight'),
                'wingspan_feet' => $request->input('wingspan_feet'),
                'wingspan_inch' => $request->input('wingspan_inch'),
                'head' => $request->input('head'),
                'education_id' => $request->input('education_id'),
                'grade' => $request->input('grade'),
                'dominant_hand' => $request->input('dominant_hand'),
                'dominant_foot' => $request->input('dominant_foot'),             
                );
                $physicalInfoData['user_id'] = $user_id;

                UserPhysicalInformation::insert($physicalInfoData);
            }

            return response()->json([
                'success' => true,
                'data'=> 'Profile',
                'message'=>'Update Successfully'
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'data'=> 'Profile',
                'message'=>'faild'
            ], 200);
        }

    }
    
    public function personalUpdateSports(Request $request)
    {
        $user_id = $request->input('user_id');
        if($user_id != ''){
            $soprtInfo = UserSport::where('user_id', $user_id)
            ->get();

            if(count($soprtInfo)>0){
                DB::table('user_sports')->where('user_id', $user_id)->delete();
                DB::table('user_sport_positions')->where('user_id', $user_id)->delete();
                $user_id= $request->input('user_id');

                $sport_id = json_decode($request->input('sport_id'));
                $sport_position_id = json_decode($request->input('sport_position_id'));
                $school_level_id = json_decode($request->input('school_level_id'));
                $other_level_id = $request->input('other_level_id');
                $competition_id = $request->input('competition_id');

                $n=0;

                    // print_r($sport_position_id);exit;
                for($i=0; $i<count($sport_id); $i++){
                    $data= array(
                        'user_id' => $user_id,
                        'sport_id' => $sport_id[$i]
                    );
                    UserSport::insert($data); 

                    for($k=$n; $k<$n+2; $k++){
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
                    $n= $n+2;
                }     
            }
            else{
                $user_id= $request->input('user_id');
                $sport_id = json_decode($request->input('sport_id'));

                $sport_position_id = json_decode($request->input('sport_position_id'));
                $school_level_id = json_decode($request->input('school_level_id'));
                $other_level_id = $request->input('other_level_id');
                
                for($i=0; $i<count($sport_id); $i++){
                    $data= array(
                        'user_id' => $user_id,
                        'sport_id' => $sport_id[$i]
                    );
                    $positionData= array(
                        'user_id' => $user_id,
                        'sport_id' => $sport_id[$i],
                        'position_id' =>$sport_position_id[$i],
                        'school_level_id'=> $school_level_id,
                        'other_level_id' => $other_level_id
                    );
                    UserSport::insert($data);
                    UserSportPosition:: insert($positionData); 
                }

            }
            return response()->json([
                'success' => true,
                'data'=> 'Profile',
                'message'=>'Update Successfully'
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'data'=> 'Profile',
                'message'=>'faild'
            ], 200);
        }

    }
    
    public function personalUpdateCollege(Request $request)
    {

        $user_id = $request->input('user_id');
        if($user_id != ''){
            $collegeInfo = UserCollege::where('user_id', $user_id)
           ->get();

           if(count($collegeInfo)>0){
                DB::table('user_colleges')->where('user_id', $user_id)->delete();
        
                $user_id=  $request->input('user_id');
            
                $college_id = json_decode($request->input('college_id'));

                for($i=0; $i<count($college_id); $i++){
                    $data= array(
                        'user_id' => $user_id,
                        'college_id' => $college_id[$i]
                    );
                    UserCollege::insert($data);       
                }  

            }else{
                
                $user_id= $request->input('user_id');
                $college_id = json_decode($request->input('college_id'));
            
                for($i=0; $i<count($college_id); $i++){
                   $data= array(
                    'user_id' => $user_id,
                    'college_id' => $college_id[$i],
                );
            
                   UserCollege::insert($data);   
               }

            }
            return response()->json([
                'success' => true,
                'data'=> 'Profile',
                'message'=>'Update Successfully'
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'data'=> 'Profile',
                'message'=>'faild'
            ], 200);
        }

    }

}