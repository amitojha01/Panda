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

class VideoEvidenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user =  auth('api')->user();
        $user_id = $user->id;
        try{
           
            $data = VideoEvidence::where('status', '!=', 3)
                            ->where('user_id', $user_id)
                            ->get();
            // print_r($data); die;
            foreach ($data as $key => $value) {
                // echo $value->id; die;
                $value->like = '';
                $likeVideoEvidence = VideoEvidenceLike::where('status', 1)->where('video_evidence_id', $value->id)->get()->count() ;
            
                $value->like = $likeVideoEvidence;
                $value->workout_category_name = '';
                $value->workout_type_name = '';
                if($value){
                    $xx = WorkoutCategory::find($value->workout_category_id);
                    if($xx ){
                        $value->workout_category_name = $xx->category_title;
                    }
                     $yy = WorkoutLibrary::find($value->workout_type_id);
                    if($yy ){
                        $value->workout_type_name = $yy->title;
                    }
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
