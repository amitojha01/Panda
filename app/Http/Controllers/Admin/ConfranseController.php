<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Confernce;
use App\Models\College;
use App\Models\CollegiateConfernce;
use DB;


class ConfranseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $confernce = Confernce::whereIn('status', [0, 1])
        ->whereNotIn('parent_id', [0])
        ->orderBy('id', 'DESC')
        ->get();
        
        return view('admin.confernce.index')
        ->with('confernce', $confernce);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $category = Confernce::whereIn('parent_id', [0])
       ->orderBy('id', 'DESC')
       ->get();
       $college = College::all();
       return view('admin.confernce.add')
       ->with('category', $category)
       ->with('college', $college);
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
        $data = $request->only(
            'name',
            'parent_id'
        );

        if(Confernce::where($data)->where('status', '!=', 9)->get()->count() > 0){
            return back()->with('error', 'Confernce name already exist');
        }
        $data['status'] = 1;

        $confrence_id= Confernce::insertGetId($data);

        if($confrence_id){
         if($college_ids= $request->input('college_id')){
            for($i=0; $i<count($college_ids);$i++){
                $confrence_data=array(
                    'collegiate_confernce_id'=> $confrence_id,
                    'college_id' => $college_ids[$i]
                );
                CollegiateConfernce::insert($confrence_data);
            }
        }
        return redirect('/admin/conference')->with('success','Conference Added Successfully');
    }
    else{
        return back()->with('error', 'Failed to add new conference ');
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
        $category = Confernce::whereIn('parent_id', [0])
        ->orderBy('id', 'DESC')
        ->get();
        $confernce = Confernce::where('id', $id)
        ->first();
        $college = College::all();

        $user_college = CollegiateConfernce::where('collegiate_confernce_id', $id)        
        ->get();
        
        return view('admin.confernce.edit')
        ->with('confernce', $confernce)
        ->with('category', $category)
        ->with('college', $college)
        ->with('user_college', $user_college);
        
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
        $data = $request->only(
            'name',
            'parent_id'
        );
        if(Confernce::where($data)->where('status', '!=', 9)->where('id', '!=', $id)->get()->count() > 0){
            return back()->with('error', 'Confernce already Exit');
        }
        $confernce = Confernce::find( $id );
        $confernce->name = $request->input('name');
        $confernce->parent_id = $request->input('parent_id');
        $confernce->status = $request->input('status');

        $confernce->save();

        $collegiate_conf = CollegiateConfernce::where('collegiate_confernce_id', $id)
        ->get();

        if(count($collegiate_conf)>0){
            DB::table('collegiate_confernce_colleges')->where('collegiate_confernce_id', $id)->delete();
            if($college_ids= $request->input('college_id')){
                for($i=0; $i<count($college_ids);$i++){
                    $college_data=array(            
                        'collegiate_confernce_id'=> $id,
                        'college_id' => $college_ids[$i]
                    );
                    CollegiateConfernce::insert($college_data);                        
                }
            }
        }else{
            if($college_ids= $request->input('college_id')){
                for($i=0; $i<count($college_ids);$i++){
                    $college_data=array(
                        'collegiate_confernce_id'=> $id,
                        'college_id' => $college_ids[$i]
                    );
                    CollegiateConfernce::insert($college_data);
                }
            }
        }
        
        return redirect('/admin/conference')->with('success','Conference Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $confernce = Confernce::find( $id );
        $confernce->status = 9;
        $confernce->save();
        
        return response()->json([
            'status' => true,
            'message' => 'Confernce deleted successfully',
        ]);
    }
}
