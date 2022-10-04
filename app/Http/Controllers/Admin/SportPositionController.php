<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Sport;
use App\Models\SportPosition;

class SportPositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(){      
       
        $position = SportPosition::whereIn('status', [0, 1])
                    ->orderBy('id', 'DESC')
                    ->get();                    
        return view('admin.sports-position.index')
                    ->with('position', $position);
    }

     public function create()
    {
        $sports = Sport::whereIn('status', [0, 1])
                    ->orderBy('id', 'DESC')
                    ->get();  
       
        return view('admin.sports-position.add')
                 ->with('sports', $sports);
    }    

    public function store(Request $request)
    {
        $request->validate([
            'sport' => 'required',
            'name' => 'required',
        ]);
        
        $data = array(
            'sport_id' =>$request->input('sport'),
            'name' =>$request->input('name'),
        );
        if(SportPosition::where($data)->where('status', '!=', 9)->get()->count() > 0){
            return back()->with('error', 'Sport name already registered');
        }
        $data['status'] = 1;
       
        if(SportPosition::insert($data)){
            return redirect('/admin/sports-position')->with('success','Position Added Successfully');
        }else{
            return back()->with('error', 'Failed to add new Position');
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
        $sports = Sport::whereIn('status', [0, 1])
                    ->orderBy('id', 'DESC')
                    ->get();
        $position = SportPosition::where('id', $id)
                            ->first();
        return view('admin.sports-position.edit')                
                ->with('sports', $sports)
                ->with('position', $position);
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
            'sport' =>'required',
            'name' => 'required|max:255'
        ]);
        //$data = $request->only('name');

        $data = array(
            'sport_id' =>$request->input('sport'),
            'name' =>$request->input('name'),
        );
        
        $position = SportPosition::find( $id );
        $position->sport_id = $request->input('sport');
        $position->name = $request->input('name');
        $position->status = $request->input('status');
        $position->save();
        
        return redirect('/admin/sports-position')->with('success','Sport Position Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {        
        $position = SportPosition::find( $id );
        $position->status = 9;
        $position->save();
        
        return response()->json([
            'status' => true,
            'message' => 'Position deleted successfully',
        ]);
    }

    

    
    
    
}
