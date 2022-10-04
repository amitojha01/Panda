<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Competition;

class CompetitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $competition = Competition::whereIn('status', [0, 1])
                    ->orderBy('id', 'DESC')
                    ->get();
        
        return view('admin.competition.index')
                    ->with('competition', $competition);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.competition.add');
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

        if(Competition::where($data)->where('status', '!=', 9)->get()->count() > 0){
            return back()->with('error', 'Competition level already');
        }
        $data['status'] = 1;
        if(Competition::insert($data)){
            return redirect('/admin/competition')->with('success','Competition Level Added Successfully');
        }else{
            return back()->with('error', 'Failed to add new competition level');
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
        $competition = Competition::where('id', $id)
                            ->first();
        
        return view('admin.competition.edit')
                ->with('competition', $competition);
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
        if(Competition::where($data)->where('status', '!=', 9)->where('id', '!=', $id)->get()->count() > 0){
            return back()->with('error', 'Competition level already Exit');
        }
        $competition = Competition::find( $id );
        $competition->name = $request->input('name');
        $competition->status = $request->input('status');

        $competition->save();
        
        return redirect('/admin/competition')->with('success','Competition Level Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $competition = Competition::find( $id );
        $competition->status = 9;
        $competition->save();
        
        return response()->json([
            'status' => true,
            'message' => 'Competition level deleted successfully',
        ]);
    }
}
