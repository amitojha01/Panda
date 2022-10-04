<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\WorkoutLibraryMeasurement;

class LibraryMesurementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mesurement_data = WorkoutLibraryMeasurement::whereIn('status', [0, 1])
        ->orderBy('id', 'DESC')
        ->get();
        
        return view('admin.measurment.index')
        ->with('mesurement_data', $mesurement_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.measurment.add');
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
            'unit' => 'required',
        ]);
        $data = $request->only(            
            'name',
            'unit',
        );

        if(WorkoutLibraryMeasurement::where($data)->where('status', '!=', 9)->get()->count() > 0){
            return back()->with('error', 'Measurement already Exist');
        }        
        $data['status'] = 1;
       

    if(WorkoutLibraryMeasurement::insert($data)){
        return redirect('/admin/libraryMesurement')->with('success',' Added Successfully');
    }else{
        return back()->with('error', 'Failed to add new measurement');
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
        $mesurement_data = WorkoutLibraryMeasurement::where('id', $id)
        ->first();
        
        return view('admin.measurment.edit')
        ->with('mesurement_data', $mesurement_data);
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
            'name' => 'required',
            'unit' => 'required',
        ]);
        $data = $request->only(            
            'name',
            'unit',
        );         

        if(WorkoutLibraryMeasurement::where($data)->where('status', '!=', 9)->where('id', '!=', $id)->get()->count() > 0){
            return back()->with('error', 'Measurement already Exist');
        }
        $measurement = WorkoutLibraryMeasurement::find( $id );
        $measurement->name = $request->input('name');
        $measurement->unit = $request->input('unit');       
        $measurement->status = $request->input('status');
        $measurement->save();
        
        return redirect('/admin/libraryMesurement')->with('success','Measurement Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $measurement = WorkoutLibraryMeasurement::find( $id );
        $measurement->status = 9;
        $measurement->save();
        
        return response()->json([
            'status' => true,
            'message' => 'Deleted successfully',
        ]);
    }
}
