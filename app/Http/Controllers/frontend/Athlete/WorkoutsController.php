<?php

namespace App\Http\Controllers\frontend\Athlete;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Models\WorkoutCategory;
use App\Models\UserWorkoutLibrary;
use App\Models\WorkoutLibrary;
use App\Models\UserWorkoutExercises;
use App\Models\UserWorkoutExerciseLog;
use App\Models\WorkoutCategoryLibrary;
use DB;

class WorkoutsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frontend.athlete.workouts.index');
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
     * Create by desctive old data
     */
    public function store(Request $request)
    {
        $librarys = $request->input('workout_library');
        $workout_id = $request->input('workout_id');
        if(!empty($librarys)){
            try{
                $librarys = explode(",", $librarys);
                UserWorkoutLibrary::where([
                                        'user_id'=> Auth()->user()->id,
                                        'workout_id' => $workout_id
                                    ])
                                    ->update([
                                        'status'=> 0
                                    ]);
                
                foreach($librarys as $val){
                    $library_list = array(
                        'workout_id' => $workout_id,
                        'workout_library_id'=>  $val,
                        'user_id'=> Auth()->user()->id
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
                //delete old data if have
                // UserWorkoutLibrary::where([
                //                             'user_id'=> Auth()->user()->id,
                //                             'workout_id' => $workout_id
                //                         ])->delete();
                // UserWorkoutLibrary::insert($library_list);
                
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * Workout lobpary
     */
    public function show($cat, $id)
    {
        // echo $cat; die;
        $workout = WorkoutLibrary::find($id);
        // dd($workout);
        
        $WorkoutCategory = WorkoutCategory::where('id',$cat)->first();
        // dd($WorkoutCategory);

        $exercise = UserWorkoutExercises::where([
                                            'workout_library_id'=> $id,
                                            'user_id'=> Auth()->user()->id
                                        ])->first();
                                        
        $userWorkoutExercises = UserWorkoutExerciseLog::where('workout_library_id',$id)->where('category_id',$cat)->where('user_id', Auth()->user()->id)->orderBy('record_date', 'asc')->where('unit_1','!=', 0)->get();
        // dd($userWorkoutExercises);
        return view('frontend.athlete.workouts.exercise')
                    ->with('exercise', $exercise)
                    ->with('category_id', $cat)
                    ->with('workout', $workout)
                    ->with('userWorkoutExercises', $userWorkoutExercises)
                    ->with('workoutCategory', $WorkoutCategory);
    }

    
    public function addVideo($cat, $id)
    {

        $workout = WorkoutLibrary::find($id);
        // dd($workout);
        
        $WorkoutCategory = WorkoutCategory::where('id',$cat)->first();
        // dd($WorkoutCategory);

        $exercise = UserWorkoutExercises::where([
                                            'workout_library_id'=> $id,
                                            'user_id'=> Auth()->user()->id
                                        ])->first();
                                        
        $userWorkoutExercises = UserWorkoutExerciseLog::where('workout_library_id',$id)->where('category_id',$cat)->where('user_id', Auth()->user()->id)->orderBy('record_date', 'asc')->where('video', '!=', "")->get();
        // dd($userWorkoutExercises);
        return view('frontend.athlete.workouts.exercise_add')
                    ->with('exercise', $exercise)
                    ->with('category_id', $cat)
                    ->with('workout', $workout)
                    ->with('userWorkoutExercises', $userWorkoutExercises)
                    ->with('workoutCategory', $WorkoutCategory);
    }

    
    /**
     * @workout category id
    */
    public function getWorkoutTips($id)
    {
        $workout_library = WorkoutCategoryLibrary::where('workout_category_id', $id)->get()->pluck('workout_library_id');
        $data = [];
        if(count($workout_library) > 0){
            $data = WorkoutLibrary::where('status', 1)->whereIn('id', $workout_library)->get();
        }
        return view('frontend.athlete.workouts.tips')
                    ->with('tips', $data);
    }

    /**
     * Saved exercise based on workout library
    */
    public function storeWorkoutExecrise(Request $request, $id)
    {
        $category_id = $request->input('category_id');
        $workout_library_id = $id;
        $unit_1 = $request->input('unit_1');
        $dec = strcspn(strrev($unit_1), '.');

        // echo $dec;
        // echo $workout_library_id;
        // die;

        if($category_id == 8 && $dec == 0){
            if($workout_library_id == 7 || $workout_library_id == 6 || $workout_library_id == 10 || $workout_library_id == 43 || $workout_library_id == 44 || $workout_library_id == 69 || $workout_library_id == 70 ){
                // $unit_1 = (int)($unit_1).toFixed(2);
                $unit_1 = number_format($unit_1, 2, '.', '');
            }
            else if($workout_library_id == 54 || $workout_library_id == 55){
                // $unit_1 = (int)($unit_1).toFixed(1);
                $unit_1 = number_format((float)$unit_1, 1, '.', ''); 
            }
            else if($workout_library_id == 76){
                // $unit_1 = (int)($unit_1);
                
                $unit_1 = round($unit_1);
            }
        }
        else if($dec == 2 && $category_id == 8){
            if($workout_library_id == 54 || $workout_library_id == 55){
                // echo "hi";
                // $unit_1 = number_format($unit_1, 1);
                $unit_1 = number_format((float)$unit_1, 1, '.', ''); 
            }
            else if($workout_library_id == 76){
                // $unit_1 =  (int)$unit_1;
                
                $unit_1 = round($unit_1, 1);

            }
        }

        else if($dec == 1 && $category_id == 8){
            if($workout_library_id == 7 || $workout_library_id == 6 || $workout_library_id == 10 || $workout_library_id == 43 || $workout_library_id == 44 || $workout_library_id == 69 || $workout_library_id == 70 ){
                // $unit_1 = (int)($unit_1).toFixed(2);
                $unit_1 = number_format($unit_1, 2, '.', '');
            }
            if($workout_library_id == 54 || $workout_library_id == 55){
                // echo "hi";
                // $unit_1 = number_format($unit_1, 1);
                $unit_1 = number_format((float)$unit_1, 1, '.', '');
            }
            else if($workout_library_id == 76){
                $unit_1 =  round($unit_1);
            }
        }
        else if($dec !== 0 && $category_id == 8){
            
            if($workout_library_id == 76){
                // $unit_1 =  (int)$unit_1;
                $unit_1 = round($unit_1);
            }
            else if($workout_library_id == 54 || $workout_library_id == 55){
                // $unit_1 = (int)($unit_1).toFixed(1);
                $unit_1 = number_format((float)$unit_1, 1, '.', ''); 
            }
            else if($workout_library_id == 7 || $workout_library_id == 6 || $workout_library_id == 10 || $workout_library_id == 43 || $workout_library_id == 44 || $workout_library_id == 69 || $workout_library_id == 70 ){
                // $unit_1 = (int)($unit_1).toFixed(2);
                $unit_1 = number_format($unit_1, 2, '.', '');
            }
        }
        // number_format((float)$unit_1, 1, '.', ''); 

        // echo $unit_1;
        // die;
          
       // echo $id;exit;
        $WorkoutCategoryLibrary = WorkoutCategoryLibrary::where('workout_category_id',$request->input('category_id'))->where('workout_library_id',$id)->first();
        $workout_category_librarys_id = $WorkoutCategoryLibrary['id'];
        // die;
        
        $data = $request->only('record_date');
        $validator = Validator::make($data, [
            'record_date'=> 'required|date'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->messages()
            ], 422);
        }
        //try{
            $data['workout_library_id'] = $id;
            $data['video'] = $request->input('video')?$request->input('video'):"";
            
            $data['unit_1'] = !empty($request->input('unit_1')) ?  $unit_1 : 0;
            $data['unit_2'] = !empty($request->input('unit_2')) ? $request->input('unit_2') : 0;
            $data['workout_category_librarys_id'] = $workout_category_librarys_id;
            $data['category_id'] = $request->input('category_id');
            $data['workout_library_id'] = $id;
            $data['record_date'] = date('Y-m-d', strtotime($data['record_date']));
            $data['user_id'] = Auth()->user()->id;
            
            $workout = UserWorkoutExercises::where(['user_id'=> Auth()->user()->id, 'workout_library_id'=> $id, 'category_id'=> $category_id])->first();

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
        // }
        // catch(\Exception $ex){
        //     return response()->json([
        //         'success'=> false,
        //         'message'=> 'Failed to add Workout excerise'
        //     ], 200);
        // }        
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getWorkoutLibrary_user(Request $request)
    {
        // echo "h"; die;
        $id = $request->input('workout_category_id');
        $user_id = Auth()->user()->id;
        try{
            $workout_library = WorkoutCategoryLibrary::where('workout_category_id', $id)->get()->pluck('workout_library_id');
            $data = [];
            if(count($workout_library) > 0){
                $data = WorkoutLibrary::where('status', 1)->whereIn('id', $workout_library)->orderBy('title', 'asc')->get();
            }else{
                $data = WorkoutLibrary::where('status', 1)->get();
            }
            foreach($data as $key => $data_value){
                $user_check = UserWorkoutLibrary::where('workout_library_id', $data_value['id'])->where('workout_id', $id)->where('user_id', $user_id )->where('status', 1)->first();
                // echo "<pre>";
                // print_r($user_check);
                // die;
                if(!empty($user_check)){
                    $data[$key]['checked'] = 1;
                }
                else{
                    $data[$key]['checked'] = 0;
                }
            }
            // echo '2h';
            // echo "<pre>";
            // print_r($data);
            // die;
           if($id != 8){
            $temp_aci = array();
            $temp_not_aci = array();
            foreach($data as $single)
            {
                // echo "<pre>";
                // print_r($single);
                if($single['is_aci_index'] == 1){
                    $temp_aci[] = $single;
                }
                if($single['is_aci_index'] == 0){
                    $temp_not_aci[] = $single;
                }
            }
            $final_data = array_merge($temp_aci,$temp_not_aci);
        }
        else{
            $final_data = $data;
        }
            // echo "<pre>";
            // print_r($data); 
            // print_r($final_data);
            // $keys = array_column($data, 'is_aci_index');
            // array_multisort($keys, SORT_ASC, $data);
            // var_dump($data);
            // die;
            return response()->json([
                'success' => true,
                'data'=> $final_data
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

    //=====

public function deleteVideo($id="")
{      

 $videoId=$id;
 if(DB::table('user_workout_exercise_logs')->where('id', $videoId )->delete()){ 
     return response()->json([
        'status' => true,
        'message' => 'Deleted successfully',
    ]);

 }else{
    return back()->with('error', 'Failed to delete member');
}
}
    public function payment(Request $request){
        $payload    = file_get_contents('php://input');
      $user_id =  Auth()->user()->id;
    
        $all_data =  $payload ?  $payload : 'sgfd';
     $values = array(
        'user_id' => Auth()->user()->id,
        'get_data' => $all_data
    );
        DB::table('stripe_payment')->insert($values);

    }
}