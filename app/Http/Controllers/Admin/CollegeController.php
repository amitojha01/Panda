<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;

use App\Models\College;
use App\Models\Confernce;
use App\Models\CollegiateConfernce;
use DB;

class CollegeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colleges = College::whereIn('status', [0, 1])
        ->orderBy('id', 'DESC')
        ->get();
        return view('admin.colleges.index')
        ->with('colleges', $colleges);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $states = State::where('country_id', '231')->get();
        $competitive_level = Confernce::whereIn('parent_id', [0])
        ->orderBy('id', 'DESC')
        ->get();
        
        return view('admin.colleges.add')
        ->with('states', $states)
        ->with('competitive_level', $competitive_level);
    }

    public function getConfrence(Request $request)
    {
        $data['confrence'] = DB::table('collegiate_confernces')->where('parent_id', $request->competitive_level_id)->get();
        return response()->json($data);
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
            'college_type' => 'required',
            'name' => 'required',
            'competitive_level_id' => 'required',
            'state_id' => 'required',
        ]);
        $data = $request->only('college_type','name','state_id', 'city_id','founded','enrollment','endowment','nickname');
        if(College::where($data)->where('status', '!=', 9)->get()->count() > 0){
            return back()->with('error', 'College name already registered');
        }
        $data['status'] = 1;

        $college_id= College::insertGetId($data);
        if($college_id){
            $collegiate_confernce_id = $request->input('collegiate_confernce_id');

            for($i=0; $i<count($collegiate_confernce_id); $i++){
               $confrenceData= array(
                'division_id' => $request->input('competitive_level_id'),
                'collegiate_confernce_id' => $collegiate_confernce_id[$i],
                'college_id' => $college_id,                
            );
               CollegiateConfernce::insert($confrenceData);
           }

           return redirect('/admin/colleges')->with('success','College Added Successfully');
       }else{
        return back()->with('error', 'Failed to add new college');
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
        $College = College::where('id', $id)
        ->first();
        
        $states = State::where('country_id', '231')->get();

        $competitive_level = Confernce::whereIn('parent_id', [0])
        ->orderBy('id', 'DESC')
        ->get();

        $collegiate_confernce = CollegiateConfernce::where('college_id', $id)        
        ->get();
        $confrences= array();
        if($collegiate_confernce){
            for($i=0; $i<count($collegiate_confernce); $i++){
                array_push($confrences, $collegiate_confernce[$i]->collegiate_confernce_id);
            } 
        }
        
        return view('admin.colleges.edit')
        ->with('college', $College)
        ->with('states', $states)
        ->with('competitive_level', $competitive_level)
        ->with('collegiate_confernce', $collegiate_confernce)
        ->with('confrences', $confrences);
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
            'college_type' => 'required',
            'name' => 'required|max:255',
            'competitive_level_id' => 'required',
            'state_id' => 'required',
        ]);
        $data = $request->only('college_type','name','state_id', 'city_id','founded','enrollment','endowment','nickname');

        if(College::where($data)->where('status', '!=', 9)->where('id', '!=', $id)->get()->count() > 0){
            return back()->with('error', 'College name already registered');
        }
        $College = College::find( $id );
        $College->name = $request->input('name');
        $College->state_id = $request->input('state_id');
        $College->status = $request->input('status');
        $College->college_type = $request->input('type');

        $College->city_id = $request->input('city_id');
        $College->founded = $request->input('founded');
        $College->enrollment = $request->input('enrollment');
        $College->endowment = $request->input('endowment');
        $College->nickname = $request->input('nickname');

        $College->save();

        $collegiate_confrence = CollegiateConfernce::where('college_id', $id)        
        ->get();

        if(count($collegiate_confrence)>0){
            DB::table('collegiate_confernce_colleges')->where('college_id', $id)->delete();
            if($confernce_ids= $request->input('collegiate_confernce_id')){
                for($i=0; $i<count($confernce_ids);$i++){
                    $cnf_data=array(

                        'division_id' => $request->input('competitive_level_id'),
                        'collegiate_confernce_id' => $confernce_ids[$i],
                        'college_id' => $id,
                    );
                    CollegiateConfernce::insert($cnf_data);
                }
            }
        }else{
             if($confernce_ids= $request->input('collegiate_confernce_id')){
                for($i=0; $i<count($confernce_ids);$i++){
                    $cnf_data=array(

                        'division_id' => $request->input('competitive_level_id'),
                        'collegiate_confernce_id' => $confernce_ids[$i],
                        'college_id' => $id,
                    );
                    CollegiateConfernce::insert($cnf_data);
                }
            }
        }

      
        return redirect('/admin/colleges')->with('success','College Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $College = College::find( $id );
        $College->status = 9;
        $College->save();
        
        return response()->json([
            'status' => true,
            'message' => 'College deleted successfully',
        ]);
    }
}
