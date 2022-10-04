<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\UserAddress;
use App\Models\Sport;
use App\Models\College;
use App\Models\Preference;
use App\Models\CoachInformation;
use App\Models\UserSport;
use App\Models\UserCollege;
use DB;

class CoachUserController extends Controller
{
    public function index()
    {
        $user = DB::table('users')->where('role_id', 2)->get();
        return view('admin.user.coach-list')
        ->with('user', $user);
    }  

    public function edit($id)
    {        
        $user = User::where('id', $id)
        ->with('address')
        ->first();      
        $country= Country::all(); 
        $states= State::all(); 
        $city = City::where('state_id', $user->address[0]->state_id)
        ->get();

         $sports = Sport::where('status', 1)->orderBy('name', 'ASC')->get();
         $college = College::where(['status'=> 1, 'type'=> 1])->get();
         $preference = Preference::all();
         $coachInfo = CoachInformation::where('user_id', $id)
        ->first(); 
         $sportInfo = UserSport::where('user_id', $id)
        ->get();
        $userSports=array();

         if($sportInfo){
            for($i=0; $i<count($sportInfo); $i++){
                array_push($userSports, $sportInfo[$i]->sport_id);
            } 
        } 

         $collegeInfo = UserCollege::where('user_id', $id)
        ->get();       
        $userCollege=array();

         if($collegeInfo){
            for($i=0; $i<count($collegeInfo); $i++){
                array_push($userCollege, $collegeInfo[$i]->college_id);
            } 
        }
        return view('admin.user.coach-edit')
        ->with('user', $user)
        ->with('country', $country)
        ->with('states', $states)
        ->with('city', $city)
        ->with('sports', $sports)
        ->with('college', $college)
        ->with('preference', $preference)
        ->with('coachInfo', $coachInfo)
        ->with('userSports', $userSports)
        ->with('sports', $sports)
        ->with('userCollege', $userCollege);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|max:255',
            'mobile' => 'required|max:10|min:10',
            'email' => 'required',
            'gender' => 'required',
            'date_of_year' => 'required',
        ]);

        $user = User::find( $id );        
        $user->username = $request->input('username');
        $user->mobile = $request->input('mobile');
        $user->email = $request->input('email');
        $user->gender = $request->input('gender'); 
        $user->profile_type = $request->input('profile_type');
        $user->date_of_year = $request->input('date_of_year');
        $user->status = $request->input('status');

        if (request()->hasFile('profile_image')) {
            $file = request()->file('profile_image');
            $fileName = time() . "." . $file->getClientOriginalExtension();
            if($file->move('public/uploads/profile/', $fileName)){
                $user->profile_image = 'public/uploads/profile/'.$fileName;
            }
        }
        $user->save();
        
        return redirect('/admin/coach')->with('success','Updated Successfully');
    } 

    public function updateAddressInfo(Request $request, $id){
       $request->validate([
        'country_id' => 'required',
        'state_id' => 'required',
        'city_id' => 'required',
        'zip'     => 'required' 
    ]);
       $addressInfo = UserAddress::where('user_id', $id)
       ->first();

       if($addressInfo ){
        $addressInfo->country_id = $request->input('country_id');
        $addressInfo->state_id = $request->input('state_id');
        $addressInfo->city_id = $request->input('city_id'); 
        $addressInfo->zip = $request->input('zip');       
        $addressInfo->status = $request->input('status');
        $addressInfo->save();
        
        return redirect('/admin/coach')->with('success','Address Information updated  Successfully');
    }else{
        $request->validate([
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'zip'     => 'required'   
        ]);
        $data = $request->only('user_id', 'country_id', 'state_id','city_id','zip','status');
        
        if(UserAddress::insert($data)){
            return redirect('/admin/user')->with('success','Address information updated successfully');
        }else{
            return back()->with('error', 'Failed to update information');
        }
    }
}

public function updateOtherInfo(Request $request, $id)
    {
        $this->validate($request, array(
            'coaching_level'=> 'required',
            'sport_id'=> 'required',
            'gender_of_coaching'=> 'required',
            'about'=> 'required|max:2500',
            'about_link'=> 'required|max:255',
            'preference_id'=> 'required'
        ));
        
        try{           
            $data = $request->only('coaching_level', 'sport_id',
                'gender_of_coaching', 'about', 'about_link', 'preference_id');
            $data['college_id'] = $request->input('college_id');
            $serve_as_reference = $request->input('serve_as_reference');
            if($serve_as_reference==""){
                $serve_as_reference =0;
            }
            $data['serve_as_reference'] = $serve_as_reference;
               
            
            $user_info = CoachInformation::where('user_id', $id)->first();
            if(!empty($user_info)){
                CoachInformation::where('user_id', $id)->update($data);
            }else{
                $data['user_id'] = $id;
                CoachInformation::create($data);
            }         

            return redirect('/admin/coach')->with('success','Other Information saved Successfully');
        }
        catch(\Exception $e)
        {
            return back()->with('error','Unable to save data');
        }
    }


public function updateSportInfo(Request $request, $id){
   $request->validate([
    'sport_id' => 'required',
    ]);
   $soprtInfo = UserSport::where('user_id', $id)
   ->get();     

   if(count($soprtInfo)>0){
    DB::table('user_sports')->where('user_id', $id)->delete();
    
    $user_id= $id;

    $sport_id = $request->input('sport_id');
    for($i=0; $i<count($sport_id); $i++){
       $data= array(
        'user_id' => $user_id,
        'sport_id' => $sport_id[$i]
    );
       UserSport::insert($data);       
   }     
   return redirect('/admin/coach')->with('success','Sport information updated successfully');
}else{
    $user_id= $id;
    $sport_id = $request->input('sport_id');

    for($i=0; $i<count($sport_id); $i++){
       $data= array(
        'user_id' => $user_id,
        'sport_id' => $sport_id[$i],
    );
       
       UserSport::insert($data);   
   }
   return redirect('/admin/coach')->with('success','Sport information updated successfully');
}
}

 public function getCollege(){
     $data['college'] = College::where(['status'=> 1, 'type'=> 1])->get(); 
        return response()->json($data);
    }


public function updateCollegeInfo(Request $request, $id){
   $request->validate([
    'college_id' => 'required',
    ]);
   $collegeInfo = UserCollege::where('user_id', $id)
   ->get();     

   if(count($collegeInfo)>0){
    DB::table('user_colleges')->where('user_id', $id)->delete();
    
    $user_id= $id;

    $college_id = $request->input('college_id');
    for($i=0; $i<count($college_id); $i++){
       $data= array(
        'user_id' => $user_id,
        'college_id' => $college_id[$i]
    );
       UserCollege::insert($data);       
   }     
   return redirect('/admin/coach')->with('success','College information updated successfully');
}else{
    $user_id= $id;
    $college_id = $request->input('college_id');

    for($i=0; $i<count($college_id); $i++){
       $data= array(
        'user_id' => $user_id,
        'college_id' => $college_id[$i],
    );
       
       UserCollege::insert($data);   
   }
   return redirect('/admin/coach')->with('success','College information updated successfully');
}
}

}
