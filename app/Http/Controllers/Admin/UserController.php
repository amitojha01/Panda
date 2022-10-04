<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Education;
use App\Models\UserPhysicalInformation;
use App\Models\Sport;
use App\Models\UserSport;
use App\Models\UserSportPosition;
use App\Models\Country;
use App\Models\UserAddress;
use App\Models\State;
use App\Models\City;
use App\Models\SchoolPlaying;
use App\Models\Travel;
use App\Models\GuardianInformation;
use DB;


class UserController extends Controller
{
    public function index()
    {
        $user = DB::table('users')->where('role_id', 1)->get();
        return view('admin.user.index')
        ->with('user', $user);
    } 

    public function edit($id)
    {        
        $user = User::where('id', $id)
        ->with('address')
        ->with('physicalInfo')
        ->first();

        $education = Education::all();
        $school_playingList = SchoolPlaying::all();
        $travelList = Travel::all();

        $sport = Sport::all(); 
        $country= Country::all(); 
        $states= State::all(); 
        $city= City::all(); 
        $sportInfo = UserSport::where('user_id', $id)
        ->get();
        $sportPosInfo = UserSportPosition::where('user_id', $id)
        ->get();
        
        $userSports= array();
        $userSportpos= array();
        $user_school_level_id ="";
        $user_other_level_id ="";

        if($sportInfo){
            for($i=0; $i<count($sportInfo); $i++){
                array_push($userSports, $sportInfo[$i]->sport_id);
            } 
        }

        if(count($sportPosInfo)>0){
            for($i=0; $i<count($sportPosInfo); $i++){
                array_push($userSportpos, $sportPosInfo[$i]->position_id);
            } 
            $user_school_level_id= $sportPosInfo[0]->school_level_id;
            $user_other_level_id= $sportPosInfo[0]->other_level_id;
        }
        
        return view('admin.user.edit')
        ->with('user', $user)
        ->with('education', $education)
        ->with('sport', $sport)
        ->with('userSports', $userSports)
        ->with('userSportpos', $userSportpos)
        ->with('country', $country)
        ->with('states', $states)
        ->with('city', $city)  
        ->with('school_playingList', $school_playingList)
        ->with('travelList', $travelList)
        ->with('user_school_level_id', $user_school_level_id)
        ->with('user_other_level_id', $user_other_level_id);
    } 

    public function getSports(){
        $data['sport'] = Sport::all(); 
        return response()->json($data);
    }

    public function getState(Request $request)
    {
        $data['states'] = DB::table('states')->where('country_id', $request->country_id)->get();
        return response()->json($data);
    }

    public function getCities(Request $request)
    {
        $data['cities'] = DB::table('cities')->where('state_id', $request->state_id)->get();
        return response()->json($data);
    } 

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|max:255',
            'mobile' => 'required|max:10|min:10',
            'email' => 'required',
            'gender' => 'required',
            'day' => 'required',
            'month' => 'required',
            'year' => 'required',
        ]);

        $user = User::find( $id );        
        $user->username = $request->input('username');
        $user->mobile = $request->input('mobile');
        $user->email = $request->input('email');
        $user->gender = $request->input('gender'); 
        $user->profile_type = $request->input('profile_type');
       // $user->date_of_year = $request->input('date_of_year');
        $user->day = $request->input('day');        
        $user->month = $request->input('month');
        $user->year = $request->input('year');
        $user->status = $request->input('status');

        if (request()->hasFile('profile_image')) {
            $file = request()->file('profile_image');
            $fileName = time() . "." . $file->getClientOriginalExtension();
            if($file->move('public/uploads/profile/', $fileName)){
                $user->profile_image = 'public/uploads/profile/'.$fileName;
            }
        }
        $user->save();
        
        return redirect('/admin/user')->with('success','User Update Successfully');
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
        
        return redirect('/admin/user')->with('success','Address Information updated  Successfully');
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



public function updatePhysicalInfo(Request $request, $id){
   $request->validate([
    'height_inch'=> 'required',
    'weight' => 'required',
    'wingspan_feet'=> 'required',
    'wingspan_inch'=> 'required',
    'head' => 'required',
]);
   $physicalInfo = UserPhysicalInformation::where('user_id', $id)
   ->first();

   if($physicalInfo){
    $physicalInfo->height_feet = $request->input('height_feet');
    $physicalInfo->height_inch = $request->input('height_inch');
    
    $physicalInfo->weight = $request->input('weight');
    $physicalInfo->wingspan_feet = $request->input('wingspan_feet');
    $physicalInfo->wingspan_inch = $request->input('wingspan_inch');
    $physicalInfo->head = $request->input('head'); 
    $physicalInfo->education_id = $request->input('education_id');
    $physicalInfo->grade = $request->input('grade');
    $physicalInfo->status = $request->input('status');
    $physicalInfo->save();

    return redirect('/admin/user')->with('success','Physical Information  Successfully');
}else{
    $request->validate([
        'height_feet' => 'required',
        'height_inch' => 'required',
        'weight' => 'required',
        'wingspan_feet' => 'required',
        'wingspan_inch' => 'required',
        'head' => 'required',           
    ]);
    $data = $request->only('user_id', 'height_feet', 'height_inch', 'weight','wingspan_feet', 'wingspan_inch','head','education_id', 'grade', 'status');

    if(UserPhysicalInformation::insert($data)){
        return redirect('/admin/user')->with('success','Physical information updated successfully');
    }else{
        return back()->with('error', 'Failed to update information');
    }
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
    DB::table('user_sport_positions')->where('user_id', $id)->delete();
    $user_id= $request->input('user_id');

    $sport_id = $request->input('sport_id');

    $sport_position_id = $request->input('sport_position_id');
    $school_level_id = $request->input('school_level_id');
    $other_level_id = $request->input('other_level_id');

    for($i=0; $i<count($sport_id); $i++){
     $data= array(
        'user_id' => $user_id,
        'sport_id' => $sport_id[$i]
    );

     $positionData= array(
        'user_id' => $user_id,
        'sport_id' => $sport_id[$i],
        'position_id' =>$sport_position_id[$i],
        'school_level_id'=> $school_level_id,
        'other_level_id' => $other_level_id
    );

     UserSport::insert($data); 
     UserSportPosition:: insert($positionData);       
 }     
 return redirect('/admin/user')->with('success','Sport information updated successfully');
}else{
    $user_id= $request->input('user_id');
    $sport_id = $request->input('sport_id');
    $sport_position_id = $request->input('sport_position_id');

    $school_level_id = $request->input('school_level_id');
    $other_level_id = $request->input('other_level_id');

    for($i=0; $i<count($sport_id); $i++){
     $data= array(
        'user_id' => $user_id,
        'sport_id' => $sport_id[$i],
    );
     $positionData= array(
        'user_id' => $user_id,
        'sport_id' => $sport_id[$i],
        'position_id' =>$sport_position_id[$i],
        'school_level_id'=> $school_level_id,
        'other_level_id' => $other_level_id
    );
     UserSport::insert($data);     
     UserSportPosition:: insert($positionData);    
 }
 return redirect('/admin/user')->with('success','Sport information updated successfully');
}

}

public function getSportPosition(Request $request)
{     
    $data['position'] = DB::table('sport_positions')->where('sport_id', $request->sport_id)->get();
    return response()->json($data);
}

public function destroyUser($id)
{       
    DB::table('users')->delete($id);
    return back()->with('success','Deleted Successfully');
} 

//==Guardian Info
public function saveGuardianInfoStep(Request $request, $id)
{
    $data = $request->all();
    $this->validate($request, array(
        'relationship' => 'required',
        'first_name'=> 'required',
        'last_name'=> 'required',
        'enable_textmessage'=> 'required',
        'primary_phone'=> 'required',
        'primary_phone_type'=> 'required',
        'is_primary_text'=> 'required',
        //'secondary_phone'=> 'required',
        //'secondary_phone_type'=> 'required',
        //'is_secondary_text'=> 'required',
        'primary_email'=> 'required'
    ));
    $guardianInfo = GuardianInformation::where('user_id', $id)
    ->first();
    if($guardianInfo ){
        $guardianInfo->relationship = $request->input('relationship');
        $guardianInfo->first_name = $request->input('first_name');
        $guardianInfo->last_name = $request->input('last_name');
        $guardianInfo->enable_textmessage = $request->input('enable_textmessage');       
        $guardianInfo->primary_phone = $request->input('primary_phone');

        $guardianInfo->primary_phone_type = $request->input('primary_phone_type');
        $guardianInfo->is_primary_text = $request->input('is_primary_text');
        $guardianInfo->secondary_phone = $request->input('secondary_phone');
        $guardianInfo->secondary_phone_type = $request->input('secondary_phone_type');
        $guardianInfo->is_secondary_text = $request->input('is_secondary_text');
        $guardianInfo->primary_email = $request->input('primary_email');
        $guardianInfo->save();
        
        return redirect('/admin/user')->with('success','Guardian  Information updated  Successfully');
    }else{

        $data = $request->only('relationship', 'first_name','last_name','enable_textmessage','primary_phone','primary_phone_type','is_primary_text','secondary_phone', 'secondary_phone_type','is_secondary_text','primary_email','status');
        $data['user_id'] = $id;
        
        if(GuardianInformation::insert($data)){
            return redirect('/admin/user')->with('success','Guardian information updated successfully');
        }else{
            return back()->with('error', 'Failed to update information');
        }
    }
}

}
