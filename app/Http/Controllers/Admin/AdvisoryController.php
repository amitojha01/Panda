<?php

namespace App\Http\Controllers\admin;

//use DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Advisory;

class AdvisoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $advisory = Advisory::whereNotIn('status',['9'])->get();


        return view('admin.advisory.index')
        ->with('advisory', $advisory);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.advisory.add');
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
            if($file->move('public/uploads/advisory/', $fileName)){
                $data['image'] = 'public/uploads/advisory/'.$fileName;
            }
        }

        if($id = Advisory::insert($data)){
            return redirect('/admin/advisory')->with('success','Advisory Board Added Successfully');
        }else{
            return back()->with('error', 'Failed to add new Advisory Board');
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
        $advisory = Advisory::where('id', $id)->first();

        return view('admin.advisory.edit')
        ->with('advisory', $advisory )                
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

        $advisory = Advisory::find( $id );
        $advisory->name = $request->input('name');
        $advisory->position = $request->input('position');
        $advisory->bio = $request->input('bio');
        $advisory->fb_link = $request->input('fb_link');
        $advisory->twitter_link = $request->input('twitter_link');
        $advisory->insta_link = $request->input('insta_link');
        $advisory->status = $request->input('status');
        if (request()->hasFile('image')) {
            $file = request()->file('image');
            $fileName = time() . "." . $file->getClientOriginalExtension();
            if($file->move('public/uploads/teams/', $fileName)){
                $advisory->image = 'public/uploads/teams/'.$fileName;
            }
        }

        $advisory->save();
        
        return redirect('/admin/advisory')->with('success','Advisory Board Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
}
