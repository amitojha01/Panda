<?php

namespace App\Http\Controllers\admin;

//use DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::whereNotIn('status',['9'])->get();
        //dd($blogs);

        //DB::enableQueryLog(); // Enable query log
        //// Your Eloquent query executed by using get()
        //dd(DB::getQueryLog()); // Show results of log

        return view('admin.teams.index')
        ->with('teams', $teams);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.teams.add');
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
            'name' => 'required|max:255',
            'position' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg',
        ]);
        $data = $request->only(            
            'name',
            'position',
            'bio',
            'fb_link',
            'twitter_link',
            'insta_link',
        );
        if (request()->hasFile('image')) {
            $file = request()->file('image');
            $fileName = time() . "." . $file->getClientOriginalExtension();
            if($file->move('public/uploads/teams/', $fileName)){
                $data['image'] = 'public/uploads/teams/'.$fileName;
            }
        }

        if($id = Team::insert($data)){
            return redirect('/admin/team')->with('success','Team Added Successfully');
        }else{
            return back()->with('error', 'Failed to add new team');
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
        $team = Team::where('id', $id)->first();

        return view('admin.teams.edit')
        ->with('team', $team )                
        ;
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
            //'page_id' => 'required',
            'name' => 'required|max:255',
            'position' => 'required',
            'status'=> 'required'
        ]);


        $data = $request->only(            
            'name',
            'position',
            'bio',
            'fb_link',
            'twitter_link',
            'insta_link',
        );

        $team = Team::find( $id );
        $team->name = $request->input('name');
        $team->position = $request->input('position');
        $team->bio = $request->input('bio');
        $team->fb_link = $request->input('fb_link');
        $team->twitter_link = $request->input('twitter_link');
        $team->insta_link = $request->input('insta_link');
        $team->status = $request->input('status');
        if (request()->hasFile('image')) {
            $file = request()->file('image');
            $fileName = time() . "." . $file->getClientOriginalExtension();
            if($file->move('public/uploads/teams/', $fileName)){
                $team->image = 'public/uploads/teams/'.$fileName;
            }
        }

        $team->save();
        
        return redirect('/admin/team')->with('success','Team Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Blog::find( $id );
        $blog->status = 9;  //for delete
        $banner->save();
        
        return response()->json([
            'status' => true,
            'message' => 'Blog deleted successfully',
        ]);
    }
}
