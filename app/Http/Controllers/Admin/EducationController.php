<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Education;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $education = Education::whereIn('status', [0, 1])
                    ->orderBy('id', 'DESC')
                    ->get();
        
        return view('admin.education.index')
                    ->with('education', $education);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.education.add');
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

        if(Education::where($data)->where('status', '!=', 9)->get()->count() > 0){
            return back()->with('error', 'Education level already');
        }
        $data['status'] = 1;
        if(Education::insert($data)){
            return redirect('/admin/education')->with('success','Education Added Successfully');
        }else{
            return back()->with('error', 'Failed to add new education level');
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
        $education = Education::where('id', $id)
                            ->first();
        
        return view('admin.education.edit')
                ->with('education', $education);
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
        if(Education::where($data)->where('status', '!=', 9)->where('id', '!=', $id)->get()->count() > 0){
            return back()->with('error', 'Education level already Exit');
        }
        $education = Education::find( $id );
        $education->name = $request->input('name');
        $education->status = $request->input('status');

        $education->save();
        
        return redirect('/admin/education')->with('success','Education Level Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $education = Education::find( $id );
        $education->status = 9;
        $education->save();
        
        return response()->json([
            'status' => true,
            'message' => 'Education deleted successfully',
        ]);
    }
}
