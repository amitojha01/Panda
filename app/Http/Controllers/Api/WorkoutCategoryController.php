<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use App\Models\WorkoutCategory;
use App\Models\WorkoutCategoryLibrary;
use App\Models\WorkoutLibrary;

//saved library by the user
use App\Models\UserWorkoutLibrary;
use App\Models\UserWorkoutExercises;
use App\Models\UserWorkoutExerciseLog;

class WorkoutCategoryController extends Controller
{
    public function index(){
        try{
            $data = WorkoutCategory::where('status', 1)->orderBy('is_aci_index', 'desc')->get();
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
     * @resuest workout id:int
     * @response list:object
     * 
    */
    public function getWorkoutLibrary(Request $request)
    {
        $id = $request->input('workout_category_id');
        try{
            $workout_library = WorkoutCategoryLibrary::where('workout_category_id', $id)->get()->pluck('workout_library_id');
            $data = [];
            if(count($workout_library) > 0){
                $data = WorkoutLibrary::where('status', 1)->whereIn('id', $workout_library)->get();
            }else{
                $data = WorkoutLibrary::where('status', 1)->get();
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
     * @resuest workout_library_id:array()
     * @response list:object
     * 
    */
    public function postWorkoutLibrary(Request $request)
    {
        $user = auth('api')->user();
        $data = $request->only('workout_id', 'workout_library');
        $validator = Validator::make($data, [
            'workout_id'=> 'required',
            'workout_library'=> 'required'
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
        $librarys = $request->input('workout_library');
        $workout_id = $request->input('workout_id');
        $user_id = $request->input('user_id');
        if(!empty($librarys)){
            try{
                UserWorkoutLibrary::where([
                                        'user_id'=> $user->id,
                                        'workout_id' => $workout_id
                                    ])
                                    ->update([
                                        'status'=> 0
                                    ]);
                
                foreach($librarys as $val){
                    $library_list = array(
                        'workout_id' => $workout_id,
                        'workout_library_id'=>  $val,
                        'user_id'=> $user->id
                    );
                    $isExists = UserWorkoutLibrary::where($library_list)->first();
                    if(!empty($isExists)){
                        UserWorkoutLibrary::where($library_list)
                                            ->update([
                                                'status'=> 1
                                            ]);
                    }else{
                        UserWorkoutLibrary::create($library_list);
                    }
                }                
                return response()->json([
                    'success'=> true,
                    'message'=> 'Workout added on dashboard successfully'
                ]);
            }
            catch(\Exception $e){
                return response()->json([
                    'success'=> false,
                    'message'=> 'Please select workout list'
                ], 500);
            }
        }else{
            return response()->json([
                'success'=> true,
                'message'=> 'Please select workout list'
            ]);
        }
    }
    /**
     * @resuest id:int
     * @response list:Object
    */
    public function getUserWorkoutLibrary(Request $request)
    {
        $user_id = $request->input('user_id');
        try{
            $workout_library = UserWorkoutLibrary::where('user_id', $user_id)->get()->pluck('workout_library_id');
            $data = [];
            if(count($workout_library) > 0){
                $data = WorkoutLibrary::where('status', 1)->whereIn('id', $workout_library)->get();
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
     * @workout category id
    */
    public function getWorkoutTips(Request $request)
    {
        $id = $request->input('workout_id');
        try{
            $workout_library = WorkoutCategoryLibrary::where('workout_category_id', $id)->get()->pluck('workout_library_id');
            $data = [];
            if(count($workout_library) > 0){
                $data = WorkoutLibrary::where('status', 1)->whereIn('id', $workout_library)->get();
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

    //Update workout excerise
    /**
     * Saved exercise based on workout library
    */
    public function storeWorkoutExecrise(Request $request)
    {
        $data = $request->only('record_date');
        $validator = Validator::make($data, [
            'record_date'=> 'required|date',
            'workout_library_id'=> 'required',
            'workout_category_id'=> 'required',
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
            $data['workout_library_id'] = $request->input('workout_library_id');
            $data['video'] = $request->input('video')?$request->input('video'):"";
            
            $data['unit_1'] = !empty($request->input('unit_1')) ?  $request->input('unit_1') : 0;
            $data['unit_2'] = empty($request->input('unit_2')) ? $request->input('unit_2') : 0;

            $data['category_id'] = $request->input('workout_category_id');
            $data['record_date'] = date('Y-m-d', strtotime($data['record_date']));
            $data['user_id'] = auth('api')->user()->id;
            $workout = UserWorkoutExercises::where(['user_id'=> $data['user_id'], 'workout_library_id'=>$data['workout_library_id']])->first();

            if(!empty($workout)){
                $data['updated_at'] = now();
                UserWorkoutExercises::where('id', $workout->id)->update($data);
            }else{
                UserWorkoutExercises::create($data);
            }

            UserWorkoutExerciseLog::create($data);
            
            return response()->json([
                'success'=> true,
                'message'=> 'Workout excerise updated successfully'
            ]);
        }
        catch(\Exception $ex){
            return response()->json([
                'success'=> false,
                'message'=> 'Failed to add Workout excerise'
            ], 200);
        }        
    }
    
}
