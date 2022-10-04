<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SchoolPlaying;

class SchoolPlayingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schoolplaying = SchoolPlaying::whereIn('status', [0, 1])
                    ->orderBy('id', 'DESC')
                    ->get();
        
        return view('admin.school-playing.index')
                    ->with('schoolplaying', $schoolplaying);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.school-playing.add');
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
        ]);
        $data = $request->only('name');

        if(SchoolPlaying::where($data)->where('status', '!=', 9)->get()->count() > 0){
            return back()->with('error', 'School Playing level already Exist');
        }
        $data['status'] = 1;
        if(SchoolPlaying::insert($data)){
            return redirect('/admin/schoolplaying')->with('success','School Playing Level Added Successfully');
        }else{
            return back()->with('error', 'Failed to add new level');
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
        $schoolplaying = SchoolPlaying::where('id', $id)
                            ->first();
        
        return view('admin.school-playing.edit')
                ->with('schoolplaying', $schoolplaying);
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
        if(SchoolPlaying::where($data)->where('status', '!=', 9)->where('id', '!=', $id)->get()->count() > 0){
            return back()->with('error', 'School Playing level already Exist');
        }
        $schoolplaying = SchoolPlaying::find( $id );
        $schoolplaying->name = $request->input('name');
        $schoolplaying->status = $request->input('status');

        $schoolplaying->save();
        
        return redirect('/admin/schoolplaying')->with('success','School Playing Level Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $schoolplaying = SchoolPlaying::find( $id );
        $schoolplaying->status = 9;
        $schoolplaying->save();
        
        return response()->json([
            'status' => true,
            'message' => 'Deleted successfully',
        ]);
    }
}
