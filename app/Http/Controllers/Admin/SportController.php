<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Sport;

class SportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sports = Sport::whereIn('status', [0, 1])
                    ->orderBy('id', 'DESC')
                    ->get();
        //dd($sports);
        return view('admin.sports.index')
                    ->with('sports', $sports);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sports.add');
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
            'name' => 'required',
            'icon' => 'image|mimes:jpg,png',
        ]);
        $data = $request->only('name');
        if(Sport::where($data)->where('status', '!=', 9)->get()->count() > 0){
            return back()->with('error', 'Sport name already registered');
        }
        $data['status'] = 1;
       
        if (request()->hasFile('icon')) {
            $file = request()->file('icon');
            $fileName = time() . "." . $file->getClientOriginalExtension();
            if($file->move('public/uploads/icons/', $fileName)){
                $data['icon'] = 'public/uploads/icons/'.$fileName;
            }
        }
        if(Sport::insert($data)){
            return redirect('/admin/sports')->with('success','Sport Added Successfully');
        }else{
            return back()->with('error', 'Failed to add new Sport');
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
        $sport = Sport::where('id', $id)
                            ->first();
        //dd($sports);
        return view('admin.sports.edit')
                ->with('sport', $sport);
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
            'name' => 'required|max:255',
            'icon' => 'image|mimes:jpg,png',
        ]);
        $data = $request->only('name');
        if(Sport::where($data)->where('status', '!=', 9)->where('id', '!=', $id)->get()->count() > 0){
            return back()->with('error', 'College name already registered');
        }
        $College = Sport::find( $id );
        $College->name = $request->input('name');
        $College->status = $request->input('status');
        
        if (request()->hasFile('icon')) {
         
            $file = request()->file('icon');
            $fileName = time() . "." . $file->getClientOriginalExtension();
            if($file->move('public/uploads/icons/', $fileName)){                
                $College->icon = 'public/uploads/icons/'.$fileName;
            }
        }
        $College->save();
        
        return redirect('/admin/sports')->with('success','Sport Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $College = Sport::find( $id );
        $College->status = 9;
        $College->save();
        
        return response()->json([
            'status' => true,
            'message' => 'Sport deleted successfully',
        ]);
    }
}
