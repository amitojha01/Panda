<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Storie;

class StoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stories = Storie::whereNotIn('status', ['9'])
                    ->orderBy('id', 'DESC')
                    ->first();
        return view('admin.stories.index')
                    ->with('stories', $stories);
    }

    /**
     * Show the form for creating a new resource.
     *
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
        $stories = Storie::where('id', $id)
                            ->with('page')
                            ->first();
        return view('admin.stories.edit')
                ->with('stories', $stories)               
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
            'title' => 'required|max:255',
            'content' => 'required',
            'image'  => 'required',
            'status'=> 'required'
        ]);

        $stories = Storie::find( $id );
        $stories->title = $request->input('title');
        $stories->content = $request->input('content');
        $stories->status = $request->input('status');
        if (request()->hasFile('image')) {
                $file = request()->file('image');
                $fileName = time() . "." . $file->getClientOriginalExtension();
                if($file->move('public/uploads/stories/', $fileName)){
                    $stories->image = 'public/uploads/stories/'.$fileName;
                }
        }

        $stories->save();
        
        return redirect('/admin/stories')->with('success','Stories Update Successfully');
       
    }

    
    
}
