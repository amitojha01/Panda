<?php

namespace App\Http\Controllers\Frontend\coach;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\WorkoutLibraryMeasurement;
use App\Models\WorkoutLibrary;
use App\Models\ReverseLookup;
use App\Models\Sport;
use App\Models\ReverseLookupSport;
use DB;


class ReverselookupController extends Controller
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
        $data = ReverseLookup::where('status', '!=', 3 )->where('user_id', Auth()->user()->id)->get();
        return view('frontend.coach.reverse-lookup.index')->with('reverseList', $data);
    }

    public function addReverse($id="")
    {
        $user_id= Auth()->user()->id;
        $sport = Sport::all(); 

        // $coach = User::where('role_id', 1)
        // ->with('address')
        // ->get(); 
        if (!empty($id)) {
          $data = ReverseLookup::where('id',$id)->first(); 
            
          $measurement_unit=WorkoutLibrary::leftJoin('workout_library_measurements', 'workout_library.measurement_id', '=', 'workout_library_measurements.id')
          ->where('workout_library.id', $data->workout_library)
          ->first();

          $lookup_sport= ReverseLookupSport::where('reverse_lookup_id', $id)->get();


          return view('frontend.coach.reverse-lookup.addReverse')
          ->with('data', $data)
          ->with('measurement_unit', $measurement_unit)
          ->with('sport', $sport)
          ->with('lookup_sport', $lookup_sport);
      }else{
        return view('frontend.coach.reverse-lookup.addReverse')
        ->with('sport', $sport);
    }

}

public function library_measurements_get(Request $request)
{

  $workout_library_id = $request->input('workout_library_id');

  $WorkoutLibrary =DB::table('workout_library')
  ->select('measurement_id')
  ->where('id', $workout_library_id )
  ->first();

  $data = array();
  if($WorkoutLibrary->measurement_id != ''){
    $data = DB::table('workout_library_measurements')->where('id', $WorkoutLibrary->measurement_id)
    ->select('name', 'unit')
    ->first();
}


return response()->json([
    'success' => true,
    'data'=> $data
], 200);
}

public function sport_position_get(Request $request)
{

  $sport_id = $request->input('sport_id');

  $data = array();
  if($sport_id != ''){
    $data = DB::table('sport_positions')->where('sport_id', $sport_id)
    ->select('name', 'id')
    ->get();
}

        // echo "<pre>";
        // print_r($data);
        // die;


return response()->json([
    'success' => true,
    'data'=> $data
], 200);
}

    public function saveReverseLookups(Request $request)
    { 
        $request->validate([
            'name' => 'required',
            'workout_library' => 'required',
            'from_criteria' => 'required',
            'to_criteria' => 'required',
            //'start_year' => 'required',
           // 'end_year' => 'required|int',
        //'sport_id' => 'required',
       // 'first_position' => 'required',
        //'second_position' => 'required',
        ]);
        try{

            $user_id= Auth()->user()->id;
            $data = $request->only('name', 'workout_library', 'from_criteria','to_criteria', 'start_year', 'end_year', 'graduation_year_from', 'graduation_year_to', );
        
            $data['user_id'] = $user_id;
        
            if (empty($request->reverseId)) {
                $last_id= ReverseLookup::insertGetId($data);

                if($last_id){  

                    $sport_id = $request->input('sport_id');
                    $first_position_id = $request->input('first_position_id');
                    $second_position_id = $request->input('second_position_id');

                    if($sport_id!=""){

                        for($i=0; $i<count($sport_id); $i++){
                         $sport_data= array(
                            'reverse_lookup_id'=> $last_id,

                            'sport_id' => $sport_id[$i],
                            'first_position_id'=> $first_position_id[$i],
                            'second_position_id' => $second_position_id[$i],
                        );
                         ReverseLookupSport::insert($sport_data); 


                     } 
                 }
         
                 return redirect('/coach/reverse-lookups')->with('success','Add Successfully');
             }else{
                return back()->with('error', 'Failed to add');
            }
        }else{
            if(ReverseLookup::where('id', $request->reverseId)->update($data)){
            
               DB::table('reverse_lookup_sports')->where('reverse_lookup_id',  $request->reverseId)->delete();

               $sport_id = $request->input('sport_id');
                    $first_position_id = $request->input('first_position_id');
                    $second_position_id = $request->input('second_position_id');

                    if($sport_id!=""){

                        for($i=0; $i<count($sport_id); $i++){
                         $sport_data= array(
                            'reverse_lookup_id'=> $request->reverseId,

                            'sport_id' => $sport_id[$i],
                            'first_position_id'=> $first_position_id[$i],
                            'second_position_id' => $second_position_id[$i],
                        );
                         ReverseLookupSport::insert($sport_data); 


                     } 
                 }

           
                return redirect('/coach/reverse-lookups')->with('success','Updated Successfully');
            }else{
                return back()->with('error', 'Failed to update');
            }
        }

    }
    catch(\Exception $e)
    {
   
        return back()->with('error','Unable to save data');
    }
}

public function deleteReverseLookup($id="")
{      
 $user_id= Auth()->user()->id;
 $eventId=$id;
 if(ReverseLookup::where('id', $eventId)->update(['status'=>3])){            
        // return redirect('/athlete/events')->with('success','Events Deleted Successfully');
    return response()->json([
        'success' => true,
        'data'=> 'ReverseLookup',
        'message'=>'Data Deleted Succesfully'
    ], 200);
}else{
    return back()->with('error', 'Failed to delete event');
}
}

public function viewReverse($id="")
{       

  $reverse_lookups = ReverseLookup::where('id', $id )
  ->first();
  $reverse_lookup_name= $reverse_lookups->name;
  $workout=  DB::table('workout_library')
  ->select('title')
  ->where('id', $reverse_lookups->workout_library)
  ->first();
  //echo $workout->title;;exit;
 
  $reverse_lookup_sport = ReverseLookupSport::where('reverse_lookup_id', $id )
  ->get();
  
  $sport= array();
  $first_position= array();
  $second_position= array();
  if(count($reverse_lookup_sport)!=""){
    foreach($reverse_lookup_sport as $sports){
      array_push($sport, $sports->sport_id);
      if($sports->first_position_id!=""){
        array_push($first_position, $sports->first_position_id);
      }
      if($sports->second_position_id!=""){        
        array_push($second_position, $sports->second_position_id);
      }

    }
  }


  $user_id = $reverse_lookups->user_id;
  $workout_library = $reverse_lookups->workout_library; 
  $from_criteria = $reverse_lookups->from_criteria;
  $to_criteria = $reverse_lookups->to_criteria;
  $start_year = $reverse_lookups->start_year;
  $end_year = $reverse_lookups->end_year;

  $graduation_year_from= $reverse_lookups->graduation_year_from;
  $graduation_year_to= $reverse_lookups->graduation_year_to;


  $query =DB::table('user_workout_exercise_logs')
  ->join('users','users.id', '=', 'user_workout_exercise_logs.user_id')
  ->join('user_sports','user_sports.user_id', '=', 'users.id')

  ->leftjoin('user_sport_positions','user_sport_positions.user_id', '=', 'users.id')
  ->where('user_workout_exercise_logs.status', 1)
  ->where('user_workout_exercise_logs.workout_library_id', $workout_library)   

  
  ->where('user_workout_exercise_logs.unit_1', '>=', $from_criteria)
  ->where('user_workout_exercise_logs.unit_1', '<=', $to_criteria)
  ->where('user_workout_exercise_logs.record_date', '!=', date('Y-m-d'));

  if($start_year!=""){
    $query= $query->where('users.year', '>=', $start_year);

  }
  if($end_year!=""){
      $query= $query->where('users.year', '<=', $end_year);

  }

  if($graduation_year_from!="" && $graduation_year_to!=""){

    $query= $query->where('users.graduation_year', '>=', $graduation_year_from)
    ->where('users.graduation_year', '<=', $graduation_year_to);
  }

  if(count($reverse_lookup_sport)!=0 && $reverse_lookup_sport[0]->sport_id!=""){
   $query= $query->whereIn('user_sports.sport_id', $sport);       

 }
 if(count($first_position)!=0 || count($second_position)!=0){
 // $query= $query->whereIn('user_sport_positions.position_id', $first_position)->
  //orWhereIn('user_sport_positions.position_id', $second_position);
   $query= $query->where(function($query) use ($first_position, $second_position){
        $query->whereIn('user_sport_positions.position_id', $first_position);
        $query->orWhereIn('user_sport_positions.position_id', $second_position);
       
    });
}

$user_lookup = $query->groupBy('users.id')->get();

$query1 =DB::table('user_workout_exercise_logs')
->join('users','users.id', '=', 'user_workout_exercise_logs.user_id')
->join('user_sports','user_sports.user_id', '=', 'users.id')

->leftjoin('user_sport_positions','user_sport_positions.user_id', '=', 'users.id')
->where('user_workout_exercise_logs.status', 1)
->where('user_workout_exercise_logs.workout_library_id', $workout_library)   

->where('user_workout_exercise_logs.unit_1', '>=', $from_criteria)
->where('user_workout_exercise_logs.unit_1', '<=', $to_criteria)
->where('user_workout_exercise_logs.record_date', date('Y-m-d'));

if($start_year!=""){
    $query1= $query1->where('users.year', '>=', $start_year);

  }
  if($end_year!=""){
      $query1= $query1->where('users.year', '<=', $end_year);

  }

if($graduation_year_from!="" && $graduation_year_to!=""){

  $query1= $query1->where('users.graduation_year', '>=', $graduation_year_from)
  ->where('users.graduation_year', '<=', $graduation_year_to);
}

//if(count($reverse_lookup_sport)!=0){
   if(count($reverse_lookup_sport)!=0 && $reverse_lookup_sport[0]->sport_id!=""){
 $query1= $query1->whereIn('user_sports.sport_id', $sport);       

}
if(count($first_position)!=0 || count($second_position)!=0){ 

    $query1= $query1->where(function($query1) use ($first_position, $second_position){
        $query1->whereIn('user_sport_positions.position_id', $first_position);
        $query1->orWhereIn('user_sport_positions.position_id', $second_position);
       
    });
}

$new_user_lookup = $query1->groupBy('users.id')->get();

     

return view('frontend.coach.reverse-lookup.searchList')
->with('user_lookup', $user_lookup)
->with('new_user_lookup', $new_user_lookup)
->with('reverse_lookup_name', $reverse_lookup_name)
->with('workout', $workout);
}
          // ->where('users.date_of_year', '>=', $start_year)
            // ->where('users.date_of_year', '<=', $end_year)

public function getSports(){    
    $data['sport'] = Sport::all(); 
    return response()->json($data);
}

public function getSportPosition(Request $request)
{     
    $data['position'] = DB::table('sport_positions')->where('sport_id', $request->sport_id)->get();
    return response()->json($data);
}
}