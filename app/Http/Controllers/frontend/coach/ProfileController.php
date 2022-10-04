<?php

namespace App\Http\Controllers\Frontend\coach;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\State;
use App\Models\Country;
use App\Models\City;
use App\Models\UserAddress;
use App\Models\Sport;
use App\Models\College;
use App\Models\CoachInformation;
use App\Models\Preference;
use App\Models\UserSport;
use App\Models\UserCollege;
use App\Models\CoachLevel;
use App\Models\Events;
use App\Models\Follower;
 use App\Models\Recommendation;
use DB;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');

    }

    public function index()
    {
        $user_id= Auth()->user()->id;
        $user = User::where('id', $user_id)       
        ->first();

        $group =DB::table('teamingup_group')
        ->leftjoin('teamingup_group_users','teamingup_group.id', '=', 'teamingup_group_users.teaming_group_id')

        ->select('teamingup_group.id','teamingup_group.group_name','teamingup_group.description','teamingup_group.image','teamingup_group.created_by','teamingup_group_users.user_id','teamingup_group_users.is_joined')->where('teamingup_group.created_by', $user_id)->groupBy('teamingup_group.id')
        ->get();
        

        $college="";
        $level_detail="";
        $coach_info = CoachInformation::where('user_id', $user_id)->first();
        if($coach_info){
            $college = College::where('id', $coach_info->college_id)->first();
             $level_detail = CoachLevel::where('id', $coach_info->coaching_level )
            ->first();
        }

        $sports =DB::table('sports')
        ->leftjoin('user_sports','sports.id', '=', 'user_sports.sport_id')

        ->select('sports.name as sportname','sports.id')
        ->where('user_sports.user_id', $user_id)
        ->where('user_sports.status', 1)
        ->first();

       /* $last_attend_event = Events::where('status', 1)->where('end_date','<=', date('m/d/Y', time()))->get();*/
       /* $upcoming_event = Events::where('status', 1)->where('start_date','>=', date('m/d/Y', time()))->get();*/

         $upcoming_event= DB::select("SELECT * FROM  events  WHERE (start_date >= '".date('Y-m-d')."' AND  end_date >= '".date('Y-m-d')."' AND `user_id` = '".Auth()->user()->id."') OR  (start_date <= '".date('Y-m-d')."' AND  end_date >= '".date('Y-m-d')."' AND `user_id` = '".Auth()->user()->id."')  AND `status` =1");

          $last_attend_event= DB::select("SELECT * FROM  events  WHERE (start_date <= '".date('Y-m-d')."' AND  end_date <= '".date('Y-m-d')."')  AND `user_id` = '".Auth()->user()->id."' AND `status` =1");

        return view('frontend.coach.profile.index')
        ->with('user', $user)
        ->with('teamingup_group', $group)
        ->with('user_info', $coach_info)
        ->with('sports', $sports)
        ->with('level_detail', $level_detail)
        ->with('last_attend_event', $last_attend_event)
        ->with('upcoming_event', $upcoming_event);
    }

    
    public function editProfile()
    {
        $user_id= Auth()->user()->id;
        $user = User::where('id', $user_id)       
        ->first();
        $sports = Sport::where('status', 1)->orderBy('name', 'ASC')->get();
        //$college = College::where(['status'=> 1, 'type'=> 1])->get();
        $coachInfo = CoachInformation::where('user_id', $user_id)
        ->first();
        $college="";
        $level_detail="";
        if($coachInfo!=""){

            $level_detail = CoachLevel::where('id', $coachInfo->coaching_level )
            ->get();
        }
        if(@$coachInfo->college_id!=""){
            $college = College::where('id', @$coachInfo->college_id )->first();

        }
        $city="";
        
        $user_state= @$user->address[0]->state_id;
        if($user_state!=""){
          $city= city::where('state_id', $user_state)->get();
        }

        $country= Country::all();
        $states= State::where('country_id', 231)
        ->orderBy('name', 'ASC')->get(); 
        $coach_level= CoachLevel::all(); 
        $preference = Preference::all();

        $sportInfo = UserSport::where('user_id', $user_id)
        ->get();
        $userSports=array();

        if($sportInfo){
            for($i=0; $i<count($sportInfo); $i++){
                array_push($userSports, $sportInfo[$i]->sport_id);
            } 
        }


        $collegeInfo = UserCollege::where('user_id', $user_id)
        ->get();       
        $userCollege=array();

         if($collegeInfo){
            for($i=0; $i<count($collegeInfo); $i++){
                array_push($userCollege, $collegeInfo[$i]->college_id);
            } 
        }

        return view('frontend.coach.profile.edit-profile')
        ->with('user', $user)
        ->with('country', $country)
        ->with('states', $states)
        ->with('city', $city)
        ->with('sports', $sports)
        ->with('college', $college)
        ->with('coachInfo', $coachInfo)
        ->with('preference', $preference)
        ->with('userSports', $userSports)
        ->with('userCollege', $userCollege)
        ->with('coach_level', $coach_level)
        ->with('level_detail', $level_detail)
        ;
    } 

    public function updateProfile(Request $request,$id){

        $request->validate([
            'username' => 'required|max:255',
            'mobile' => 'required|max:10|min:10',
            'email' => 'required',
            'gender' => 'required',
        ]);

        $user = User::find( $id );        
        $user->username = $request->input('username');
        $user->mobile = $request->input('mobile');
        $user->email = $request->input('email');
        $user->gender = $request->input('gender'); 
        $user->profile_type = $request->input('profile_type');
         $user->contact_email = $request->input('contact_email');


        if (request()->hasFile('profile_image')) {
            $file = request()->file('profile_image');
            $fileName = time() . "." . $file->getClientOriginalExtension();
            if($file->move('public/uploads/profile/', $fileName)){
                $user->profile_image = 'public/uploads/profile/'.$fileName;
            }
        }
        $user->save();
        
        return redirect('/coach/edit-profile')->with('success','User Update Successfully');
    }

    public function updateAddress(Request $request,$id){

        $addressInfo = UserAddress::where('user_id', $id)
        ->first();               
        if($addressInfo ){
            $addressInfo->country_id = $request->input('country_id');
            $addressInfo->state_id = $request->input('state_id');
            $addressInfo->city_id = $request->input('city_id'); 
            $addressInfo->zip = $request->input('zip'); 
            $addressInfo->save();

            return redirect('/coach/edit-profile')->with('success','Address  updated  Successfully');
        }else{
            $request->validate([
                'country_id' => 'required',
                'state_id' => 'required',
                'city_id' => 'required',
                'zip'     => 'required'   
            ]);
            $data = $request->only('country_id', 'state_id','city_id','zip');
            $data['user_id'] = $id;

            if(UserAddress::insert($data)){            
                return redirect('/coach/edit-profile')->with('success','Address  Updated  Successfully');
            }else{
                return back()->with('error', 'Failed to update information');
            }
        }
    }

    public function getState(Request $request)
    {
        $data['states'] = DB::table('states')->where('country_id', $request->country_id)->orderBy('name', 'ASC')->get();
        return response()->json($data);
    }

    public function getCities(Request $request)
    {
        $data['cities'] = DB::table('cities')
        ->where('state_id', $request->state_id)
        ->orderBy('name', 'ASC')->get();
        return response()->json($data);
    }

    public function updateOtherInfo(Request $request, $id)
    {
        $this->validate($request, array(
            'coaching_level'=> 'required',
            //'sport_id'=> 'required',
            'gender_of_coaching'=> 'required',
            'about'=> 'required|max:2500',
            'about_link'=> 'required|max:255',
            'preference_id'=> 'required',
            'coaching_sport' => 'required',
        ));
        
        try{           
           /* $data = $request->only('coaching_level', 'sport_id',
                'gender_of_coaching', 'about', 'about_link', 'preference_id');*/

            $data = $request->only('coaching_level',
                   'gender_of_coaching', 'about', 'about_link', 'share_contact', 'preference_id', 'coaching_sport','sport_level', 'team_name','number_of_years','primary_age_group');

            if($data['coaching_level'] == '2'){              
                $data['college_id'] = $request->input('college_id');
            }else{
                $data['coach_level_name'] = $request->input('coach_level_name');
                
            }
             $data['club_name'] = $request->input('club_name');
            // echo $data['club_name'];exit;
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
            return redirect('/coach/edit-profile')->with('success','Updated  Successfully');
        }
        catch(\Exception $e)
        {
            return back()->with('error','Unable to save data');
        }
    }

    public function getSports(){
        $data['sport'] = Sport::all(); 
        return response()->json($data);
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
     return redirect('/coach/edit-profile')->with('success','Sport Updated  Successfully');  
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
 return redirect('/coach/edit-profile')->with('success','Sport Updated  Successfully');  
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
    return redirect('/coach/edit-profile')->with('success','College Updated  Successfully');  
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
    return redirect('/coach/edit-profile')->with('success','College Updated  Successfully');
}
}

public function changeReadStatus(){ 

  if(Follower::where("read_status",0)->where("user_id", Auth()->user()->id)->orwhere("follower_id", Auth()->user()->id)->update(array('read_status' =>'1'))){

    Recommendation::where("read_status",0)->where("receiver_id", Auth()->user()->id)->update(array('read_status' =>'1'));

    return 1;
  }else{
    return 0;
  }
}



}
