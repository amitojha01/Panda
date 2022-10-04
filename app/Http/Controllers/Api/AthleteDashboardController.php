<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use App\Models\VideoEvidence;
use App\Models\VideoEvidenceLike;
use App\Models\WorkoutCategory;
use App\Models\WorkoutLibrary;
use App\Models\State;

use App\Models\Gamehighlight;
use App\Models\Education;

use App\Models\Teaming;

use App\Models\User;
use App\Models\UserWorkoutLibrary;
use App\Models\UserWorkoutExercises;
use App\Models\WorkoutLibraryMeasurement;

use App\Models\UserAciIndexLog;
use DB;
use URL;

class AthleteDashboardController extends Controller
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
        //$user_id = $request->input('user_id');
        try{
            // echo 'dd';
            //$user = User::where('id', $user_id)->where('status', '!=', 0)->first();
            $user = auth('api')->user();
            $user_id = $user->id;
            // echo "<pre>";
            // print_r($user->email);
            $user_aci_rank = $this->aciRankCalculate($user->id);
            // print_r($user_aci_rank);

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
                        $measurement = WorkoutLibraryMeasurement::where('id', $temp_all_value->measurement_id)
                                                                    ->select('name', 'unit')
                                                                    ->first();
                        //print_r($temp);
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

            $athlete_flower_user = array();
            if(count($all_athlete_flower) != ''){
                foreach ($all_athlete_flower as $athlete_flower) {

                    $athlete_flower_user['id'] = $athlete_flower->id ;
                    $athlete_flower_user['role_id'] = $athlete_flower->role_id ;
                    $athlete_flower_user['username'] = $athlete_flower->username ;
                    $athlete_flower_user['email'] = $athlete_flower->email ;
                    $athlete_flower_user['gender'] = $athlete_flower->gender ;
                    $athlete_flower_user['profile_type'] = $athlete_flower->profile_type ;
                    $athlete_flower_user['profile_image'] = $athlete_flower->profile_image ;
                    $all_athlete_flower_user[] = $athlete_flower_user;
                }
            }
            else{
                $all_athlete_flower_user = array();

            }


            $all_coaches_flower =DB::table('followers')
            ->join('users','users.id', '=', 'followers.follower_id')
            ->select('users.*')
            ->where('followers.user_id', $user_id )
            ->where('users.role_id',  '2')
            ->where('users.status','!=', 0)
            ->where('followers.status', 1)
            ->get();
            // print_r($all_coaches_flower); 

            $coaches_flower_user = array();
            if(count($all_coaches_flower) != ''){
                // echo 'fdef'; die;
                foreach ($all_coaches_flower as $coaches_flower) {

                    $coaches_flower_user['id'] = $coaches_flower->id ;
                    $coaches_flower_user['role_id'] = $coaches_flower->role_id ;
                    $coaches_flower_user['username'] = $coaches_flower->username ;
                    $coaches_flower_user['email'] = $coaches_flower->email ;
                    $coaches_flower_user['gender'] = $coaches_flower->gender ;
                    $coaches_flower_user['profile_type'] = $coaches_flower->profile_type ;
                    $coaches_flower_user['profile_image'] = $coaches_flower->profile_image ;
                    $all_coaches_flower_user[] = $coaches_flower_user;
                }
                
            }
            else{
                $all_coaches_flower_user = array();
            }
        
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
            $data['user_aci_rank'] = $user_aci_rank;
            $data['workout_librarys'] = $workout_librarys;
            $data['graph-api'] = URL::to('api/dashboard-graph-api/'.$user_id);
            $data['total_video_evidence'] = $total_video_evidence;
            $data['total_game_highlight'] = $total_game_highlight;
            $data['all_athlete_flower_user'] = $all_athlete_flower_user;
            $data['all_coaches_flower_user'] = $all_coaches_flower_user;
            $data['all_teamingup_group'] = $all_teamingup_group;
        
        
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

}