<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Service;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::whereNotIn('status', ['9'])
                    ->orderBy('id', 'DESC')
                    ->first();
        return view('admin.services.index')
                    ->with('services', $services);
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
        $services = Service::where('id', $id)
                            ->first();
        //dd($services);
        return view('admin.services.edit')
                ->with('services', $services)               
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
            'status'=> 'required'
        ]);

        $services = Service::find( $id );
        $services->title = $request->input('title');
        $services->content = $request->input('content');
        $services->status = $request->input('status');
        if (request()->hasFile('image')) {
                $file = request()->file('image');
                $fileName = time() . "." . $file->getClientOriginalExtension();
                if($file->move('public/uploads/servicess/', $fileName)){
                    $services->image = 'public/uploads/servicess/'.$fileName;
                }
        }

        $services->save();
        
        return redirect('/admin/services')->with('success','Services Update Successfully');
       
    }

}
