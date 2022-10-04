<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Testimonial;

class TestimonialContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonial = Testimonial::whereNotIn('status', ['9'])
                    ->orderBy('id', 'DESC')
                    ->first();
        return view('admin.testimonial.index')
                    ->with('testimonial', $testimonial);
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
        $testimonial = Testimonial::where('id', $id)
                            ->first();
        return view('admin.testimonial.edit')
                ->with('testimonial', $testimonial)               
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
            'ratings'  => 'required',
            'status'=> 'required'
        ]);

        $testimonial = Testimonial::find( $id );
        $testimonial->title = $request->input('title');
        $testimonial->content = $request->input('content');
        $testimonial->ratings = $request->input('ratings');
        $testimonial->status = $request->input('status');

        $testimonial->save();
        
        return redirect('/admin/testimonial')->with('success','Testimonial Update Successfully');
       
    }

    
    
}
