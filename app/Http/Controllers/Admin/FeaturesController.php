<?php

namespace App\Http\Controllers\admin;

//use DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//use App\Models\Page;
use App\Models\Feature;

class FeaturesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $features = Feature::whereNotIn('status',['9'])->get();
        //dd($blogs);

        //DB::enableQueryLog(); // Enable query log
        //// Your Eloquent query executed by using get()
        //dd(DB::getQueryLog()); // Show results of log

        return view('admin.features.index')
                    ->with('features', $features);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.features.add');
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
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg',
        ]);
        $data = $request->only(            
            'title',
            'content'
        );
        if (request()->hasFile('image')) {
                $file = request()->file('image');
                $fileName = time() . "." . $file->getClientOriginalExtension();
                if($file->move('public/uploads/features/', $fileName)){
                    $data['image'] = 'public/uploads/features/'.$fileName;
                }
        }

        if($id = Feature::insert($data)){
            return redirect('/admin/features')->with('success','Features Added Successfully');
        }else{
            return back()->with('error', 'Failed to add new banner');
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
        $features = Feature::where('id', $id)->first();
        //$pages = Page::all();
        //dd($blog);
        return view('admin.features.edit')
                //->with('banner', $banner)
                ->with('features', $features)                
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

        $features = Feature::find( $id );
        //$banner->page_id = $request->input('page_id');
        $features->title = $request->input('title');
        $features->content = $request->input('content');
        $features->status = $request->input('status');
        if (request()->hasFile('image')) {
                $file = request()->file('image');
                $fileName = time() . "." . $file->getClientOriginalExtension();
                if($file->move('public/uploads/features/', $fileName)){
                    $features->image = 'public/uploads/features/'.$fileName;
                }
        }

        $features->save();
        
        return redirect('/admin/features')->with('success','Features Updated Successfully');
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Feature::find( $id );
        $blog->status = 9;  //for delete
        $banner->save();
        
        return response()->json([
            'status' => true,
            'message' => 'Features deleted successfully',
        ]);
    }
}
