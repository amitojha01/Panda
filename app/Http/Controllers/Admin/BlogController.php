<?php

namespace App\Http\Controllers\admin;

//use DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//use App\Models\Page;
use App\Models\Blog;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::whereNotIn('status',['9'])->get();
        //dd($blogs);

        //DB::enableQueryLog(); // Enable query log
        //// Your Eloquent query executed by using get()
        //dd(DB::getQueryLog()); // Show results of log

        return view('admin.blogs.index')
                    ->with('blogs', $blogs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.blogs.add');
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
                if($file->move('public/uploads/blogs/', $fileName)){
                    $data['image'] = 'public/uploads/blogs/'.$fileName;
                }
        }

        if($id = Blog::insert($data)){
            return redirect('/admin/blogs')->with('success','Blog Added Successfully');
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
        $blog = Blog::where('id', $id)->first();
        //$pages = Page::all();
        //dd($blog);
        return view('admin.blogs.edit')
                //->with('banner', $banner)
                ->with('blog', $blog)                
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

        $blog = Blog::find( $id );
        //$banner->page_id = $request->input('page_id');
        $blog->title = $request->input('title');
        $blog->content = $request->input('content');
        $blog->status = $request->input('status');
        if (request()->hasFile('image')) {
                $file = request()->file('image');
                $fileName = time() . "." . $file->getClientOriginalExtension();
                if($file->move('public/uploads/blogs/', $fileName)){
                    $blog->image = 'public/uploads/blogs/'.$fileName;
                }
        }

        $blog->save();
        
        return redirect('/admin/blogs')->with('success','Blog Updated Successfully');
       
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
