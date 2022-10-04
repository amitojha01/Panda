<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\WorkoutLibrary;
use App\Models\WorkoutLibraryMeasurement;
use App\Models\Sport;

class WorkoutLibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workout_data = WorkoutLibrary::whereIn('status', [0, 1])
        ->orderBy('id', 'DESC')
        ->get();
        
        return view('admin.workout.index')
        ->with('workout_data', $workout_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $measurements = WorkoutLibraryMeasurement::where('status', 1)->get();
         $sports = Sport::where('status', 1)
                    ->orderBy('id', 'DESC')
                    ->get();
        return view('admin.workout.add')
                    ->with('measurements', $measurements)
                    ->with('sports', $sports);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'measurement_id'=> 'required',
            'video'=> 'required'
        ]);
        $data = $request->only( 
            'title',
            'description',
            'video',
            'is_aci_index',
            'measurement_id',
            
        );
        $title= $request->input('title');
        $sport_id= $request->input('sport_id');
        if($sport_id!=""){
            $sport_name= Sport::select('name')->where('id', @$sport_id)->first();
            $data['sport_id']=$sport_id;
            $data['sport_category_title'] = $sport_name->name.'-'.$title;
        }

        

        if(WorkoutLibrary::where($data)->where('status', '!=', 9)->get()->count() > 0){
            return back()->with('error', 'Workout Library already Exist');
        }        
        $data['status'] = 1;
       
        if(WorkoutLibrary::insert($data)){
            return redirect('/admin/workoutlibrary')->with('success',' Added Successfully');
        }else{
            return back()->with('error', 'Failed to add new library');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $workout_data = WorkoutLibrary::where('id', $id)
        ->first();
        $measurements = WorkoutLibraryMeasurement::where('status', 1)->get();
         $sports = Sport::where('status', 1)
                    ->orderBy('id', 'DESC')
                    ->get();
        return view('admin.workout.edit')
                ->with('measurements', $measurements)
                ->with('workout_data', $workout_data)
                ->with('sports', $sports);
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

        $request->validate([
            'title' => 'required',
            'measurement_id'=> 'required',
            'video'=> 'required'
        ]);
        $data = $request->only(            
            'title',
            'description',
            'video',
            'is_aci_index',
            'tips_content',
            'measurement_id'
        );         

        if(WorkoutLibrary::where($data)->where('status', '!=', 9)->where('id', '!=', $id)->get()->count() > 0){
            return back()->with('error', 'Library already Exist');
        }


        $workoutlibrary = WorkoutLibrary::find( $id );
        $workoutlibrary->title = $request->input('title');
        $workoutlibrary->description = $request->input('description');
        $workoutlibrary->video = $request->input('video');
         $workoutlibrary->is_aci_index = $request->input('is_aci_index');
        $workoutlibrary->measurement_id = $request->input('measurement_id');
        $workoutlibrary->tips_content = $request->input('tips_content');
        $workoutlibrary->status = $request->input('status');

        $title= $request->input('title');
        $sport_id= $request->input('sport_id');
        if($sport_id!=""){
            $sport_name= Sport::select('name')->where('id', @$sport_id)->first();

            $workoutlibrary->sport_id = $sport_id;
            $workoutlibrary->sport_category_title = $sport_name->name.'-'.$title;
            
        }else{
            $workoutlibrary->sport_id = "";
            $workoutlibrary->sport_category_title = "";

        }

        $workoutlibrary->save();
        
        return redirect('/admin/workoutlibrary')->with('success','Library Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $workoutlibrary = WorkoutLibrary::find( $id );
        $workoutlibrary->status = 9;
        $workoutlibrary->save();
        
        return response()->json([
            'status' => true,
            'message' => 'Deleted successfully',
        ]);
    }
}
