<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use DB;

class SettingsController extends Controller
{
    public function index()
    {
       
        $setting = Setting::all();
        return view('admin.settings.settings')
        ->with('setting', $setting);
    }

    public function create()
    {
        return view('admin.settings.add');
                    
    }

    public function store(Request $request)
    {
        $request->validate([
            'field_title' => 'required',
        ]);
        /*$data = $request->only(
            'key' =>$request->input('field_title'),
            'value'=>  $request->input('field_value'),
            
        );*/
        $data= array(
            'key' =>$request->input('field_title'),
            'value'=>  $request->input('field_value'),
        );
       

        if($id = setting::insert($data)){
            return redirect('/admin/settings')->with('success','Field Added Successfully');
        }else{
            return back()->with('error', 'Failed to add new Field');
        }
    }

    public function update(Request $request)
    {
        $field_value = $request->input('field_value'); 
        $field_id = $request->input('field_id');
        for($i=0; $i<count($field_id); $i++){
             DB::table('settings')
        ->where('id', $field_id[$i])
        ->update(['value' => $field_value[$i]]);       

        }  
        return redirect()->back()->with('success','Settings Update Successfully'); 
}

       
    
    

    public function updateold(Request $request, $id)
    {
        $request->validate([
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required'
        ]);

        $setting = Setting::find( $id );
        $setting->address = $request->input('address');
        $setting->phone = $request->input('phone');
        $setting->email = $request->input('email');
        $setting->fb_link = $request->input('fb_link');
        $setting->twitter_link = $request->input('twitter_link');
        $setting->instagram_link = $request->input('instagram_link');
        $setting->youtube_link = $request->input('youtube_link');
        

        $setting->save();
        
        return redirect()->back()->with('success','Settings Update Successfully');
       
    }
}
