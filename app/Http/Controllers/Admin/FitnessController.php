<?php

namespace App\Http\Controllers\admin;

//use DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//use App\Models\Page;
use App\Models\Fitness;

class FitnessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fitness = Fitness::whereNotIn('status',['9'])->get();
        //dd($blogs);

        //DB::enableQueryLog(); // Enable query log
        //// Your Eloquent query executed by using get()
        //dd(DB::getQueryLog()); // Show results of log

        return view('admin.fitness.index')
                    ->with('fitness', $fitness);
    }

   
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
        $fitness = Fitness::where('id', $id)->first();
        //$pages = Page::all();
        //dd($blog);
        return view('admin.fitness.edit')
                //->with('banner', $banner)
                ->with('fitness', $fitness)                
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
            'title' => 'required|max:255',
            'content' => 'required',
            'status'=> 'required'
        ]);

        $fitness = Fitness::find( $id );
        //$banner->page_id = $request->input('page_id');
        $fitness->title = $request->input('title');
        $fitness->content = $request->input('content');
        $fitness->status = $request->input('status');

        $fitness->save();
        
        return redirect('/admin/fitness')->with('success','Fitness Updated Successfully');
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Fitness::find( $id );
        $blog->status = 9;  //for delete
        $banner->save();
        
        return response()->json([
            'status' => true,
            'message' => 'Fitness deleted successfully',
        ]);
    }
}
