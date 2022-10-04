<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;

use App\Models\City;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = State::where('country_id', '231')->get();
        $city = City::wherein('state_id', $states)
                    ->get();
                  
        return view('admin.city.index')
                 ->with('states', $states)
                  ->with('city', $city);
    }

  
    public function edit($id)
    {     
        
        $city = City::where('id', $id)->first();        
        $states = State::where('id', $city->state_id)
                            ->first();
        
        return view('admin.city.edit')               
                ->with('states', $states)
                 ->with('city', $city);
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
            'name' => 'required',
            'zip' => 'required'
        ]);
        $data = $request->only('name','zip');
        if(City::where($data)->where('id', '!=', $id)->get()->count() > 0){
            return back()->with('error', 'Already Exist');
        }
        $city = City::find( $id );
        $city->name = $request->input('name');
        $city->zip = $request->input('zip');
        $city->save();
        
        return redirect('/admin/cities')->with('success','Cities Update Successfully');
    }

    
   
}
