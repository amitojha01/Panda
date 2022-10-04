<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Travel;

class TravelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $travel = Travel::whereIn('status', [0, 1])
                    ->orderBy('id', 'DESC')
                    ->get();
        
        return view('admin.travel.index')
                    ->with('travel', $travel);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.travel.add');
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
        ]);
        $data = $request->only('name');

        if(Travel::where($data)->where('status', '!=', 9)->get()->count() > 0){
            return back()->with('error', 'Travel name  already exist');
        }
        $data['status'] = 1;
        if(Travel::insert($data)){
            return redirect('/admin/travel')->with('success','Travel name added successfully');
        }else{
            return back()->with('error', 'Failed to add new travel');
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
        $travel = Travel::where('id', $id)
                            ->first();
        
        return view('admin.travel.edit')
                ->with('travel', $travel);
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
            'name' => 'required|max:255'
        ]);
        $data = $request->only('name');
        if(Travel::where($data)->where('status', '!=', 9)->where('id', '!=', $id)->get()->count() > 0){
            return back()->with('error', 'Travel level already Exist');
        }
        $travel = Travel::find( $id );
        $travel->name = $request->input('name');
        $travel->status = $request->input('status');

        $travel->save();
        
        return redirect('/admin/travel')->with('success','Travel Name Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $travel = Travel::find( $id );
        $travel->status = 9;
        $travel->save();
        
        return response()->json([
            'status' => true,
            'message' => 'Travel name deleted successfully',
        ]);
    }
}
