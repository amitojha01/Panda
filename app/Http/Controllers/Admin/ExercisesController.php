<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Exercise;

class ExercisesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exercises = Exercise::whereIn('status', [0, 1])
                    ->orderBy('id', 'DESC')
                    ->get();
        //dd($Colleges);
        return view('admin.exercises.index')
                    ->with('exercises', $exercises);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.exercises.add');
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
            'name' => 'required',
            'description' => 'required',
            'tips_video' => 'required|url',
            'min_count' => 'required',
            'max_count' => 'required',
        ]);
        $data = $request->only('name');
        if(Exercise::where($data)->where('status', '!=', 9)->get()->count() > 0){
            return back()->with('error', 'Exercise name already registered');
        }
        $data = $request->only('name', 'description', 'tips_video', 'min_count', 'max_count');
        $data['status'] = 1;
        //dd($data);
        if(Exercise::insert($data)){
            return redirect('/admin/exercises')->with('success','Exercise Added Successfully');
        }else{
            return back()->with('error', 'Failed to add new Exercise');
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
        $exercise = Exercise::where('id', $id)
                            ->first();
        //dd($Colleges);
        return view('admin.exercise.edit')
                ->with('exercise', $exercise);
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
            'name' => 'required|max:255'
        ]);
        $data = $request->only('name');
        if(Exercise::where($data)->where('status', '!=', 9)->where('id', '!=', $id)->get()->count() > 0){
            return back()->with('error', 'College name already registered');
        }
        $College = Exercise::find( $id );
        $College->name = $request->input('name');
        $College->status = $request->input('status');

        $College->save();
        
        return redirect('/admin/exercise')->with('success','College Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exercise = Exercise::find( $id );
        $exercise->status = 9;
        $exercise->save();
        
        return response()->json([
            'status' => true,
            'message' => 'Exercise deleted successfully',
        ]);
    }
}
