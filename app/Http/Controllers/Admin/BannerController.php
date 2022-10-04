<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Page;
use App\Models\Banner;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::whereNotIn('status', ['9'])
                    ->with('page')
                    ->orderBy('id', 'DESC')
                    ->get();
        //dd($banners);
        return view('admin.banners.index')
                    ->with('banners', $banners);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banners.add')
                    ->with('pages', Page::all());
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
            'page_id' => 'required',
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg',
        ]);
        $data = $request->only(
            'page_id',
            'title',
            'content'
        );
        if (request()->hasFile('image')) {
                $file = request()->file('image');
                $fileName = time() . "." . $file->getClientOriginalExtension();
                if($file->move('public/uploads/banners/', $fileName)){
                    $data['image'] = 'public/uploads/banners/'.$fileName;
                }
        }

        if($id = Banner::insert($data)){
            return redirect('/admin/banners')->with('success','Banner Added Successfully');
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
        $banner = Banner::where('id', $id)
                            ->with('page')
                            ->first();
        $pages = Page::all();
        //dd($banner);
        return view('admin.banners.edit')
                ->with('banner', $banner)
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
            'page_id' => 'required',
            'title' => 'required|max:255',
            'content' => 'required',
            'status'=> 'required'
        ]);

        $banner = Banner::find( $id );
        $banner->page_id = $request->input('page_id');
        $banner->title = $request->input('title');
        $banner->content = $request->input('content');
        $banner->status = $request->input('status');
        if (request()->hasFile('image')) {
                $file = request()->file('image');
                $fileName = time() . "." . $file->getClientOriginalExtension();
                if($file->move('public/uploads/banners/', $fileName)){
                    $banner->image = 'public/uploads/banners/'.$fileName;
                }
        }

        $banner->save();
        
        return redirect('/admin/banners')->with('success','Banner Update Successfully');
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Banner::find( $id );;
        $banner->is_deleted = 1;
        $banner->save();
        
        return response()->json([
            'status' => true,
            'message' => 'Bnner deleted successfully',
        ]);
    }
}
