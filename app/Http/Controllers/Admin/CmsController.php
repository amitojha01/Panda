<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cms;
use App\Models\Page;

class CmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $cms_data = Cms::all();
                            
        return view('admin.cms.index')
                    ->with('cms_data', $cms_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pages = Page::all();
        return view('admin.cms.add')
                    ->with('pages', $pages);
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
            'page_slug' => 'required',
            'content' => 'required'
        ]);
        $data = $request->only(
            'page_slug',
            'content',
            'section',
            'title'
        );
        if (request()->hasFile('image')) {
            $file = request()->file('image');
            $fileName = time() . "." . $file->getClientOriginalExtension();
            if($file->move('public/uploads/images/', $fileName)){
                $data['image'] = 'public/uploads/images/'.$fileName;
            }
        }

        if($id = Cms::insert($data)){
            return redirect('/admin/cms')->with('success','CMS Content Added Successfully');
        }else{
            return back()->with('error', 'Failed to add new CMS Content');
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
        $cms = Cms::where('id', $id)
                            ->with('page')
                            ->first();
        $pages = Page::all();       
        return view('admin.cms.edit')
                ->with('cms', $cms)
                ->with('pages', $pages)                
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
            'page_slug' => 'required',
            'content' => 'required'
        ]);
        $cms = Cms::find( $id );
        $cms->page_slug = $request->input('page_slug');

        $cms->title = $request->input('title');
        $cms->section = $request->input('section');


        $cms->content = $request->input('content');
        $cms->status = $request->input('status');
        if (request()->hasFile('image')) {
            $file = request()->file('image');
            $fileName = time() . "." . $file->getClientOriginalExtension();
            if($file->move('public/uploads/images/', $fileName)){
                $cms->image = 'public/uploads/images/'.$fileName;
            }
        }

        $cms->save();
        
        return redirect('/admin/cms')->with('success','CMS Update Successfully');  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Cms::find( $id );;
        $banner->is_deleted = 1;
        $banner->save();
        
        return response()->json([
            'status' => true,
            'message' => 'Bnner deleted successfully',
        ]);
    }
}
