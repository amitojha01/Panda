<?php

namespace App\Http\Controllers\Api\Coach;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;

use App\Models\User;
use App\Models\Sport;
use App\Models\SportPosition;
use App\Models\UserSport;
use App\Models\UserCollege;
use App\Models\UserAddress;
use App\Models\UserSubscription;
use App\Models\CoachInformation;
use App\Models\CoachLevel;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    //use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    public function saveStepOne(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'username' => 'required|unique:users,username',
            'password'=> 'required|min:8',
            'email'=> 'required|email|unique:users,email',
            'mobile'=> 'required|unique:users,mobile',
            'gender'=> 'required',
        ]);
        if ($validator->fails()) {
            $err= $validator->errors();
            $err_msg = '';
            foreach(json_decode($err) as $key=> $val){
                $err_msg = $val[0];
                break;
            }
            return response()->json([
                'success' => false,
                'error' => $err_msg
            ], 422);
        }
        try{
            $data = $request->only('username', 'password', 'email', 'mobile', 'gender', 'profile_type');
            $data['password'] = Hash::make($data['password']);
            $data['status'] = 10;
            $data['role_id'] = 2;
            if($user = User::create($data)){
                return response()->json([
                    'success' => true,
                    'message' => "Basic informations saved successfully",
                    'data'=> $user
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => "Failed to saved Basic information."
                ], 200);
            }
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to saved Basic information."
            ], 500);
        }
    }

    /**
     * @request input formdata
    **/
    public function saveAddressStep(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'country_id'=> 'required',
            'state_id'=> 'required',
            'city_id'=> 'required',
            'zip'=> 'required',
            'user_id'=> 'required'
        ]);
        if ($validator->fails()) {
            $err= $validator->errors();
            $err_msg = '';
            foreach(json_decode($err) as $key=> $val){
                $err_msg = $val[0];
                break;
            }
            return response()->json([
                'success' => false,
                'error' => $err_msg
            ], 422);
        }
        try{
            $data = $request->only('country_id', 'state_id', 'city_id', 'zip', 'user_id');
            $id = $request->input('user_id');
            if(!$user = User::find($id)){
                return response()->json([
                    'success' => false,
                    'message' => "Unable to process request. User not found"
                ], 200);
            }
            // old data if have
            if(!empty(UserAddress::where('user_id', $id)->first())){
                UserAddress::where('user_id', $id)->update($data);
            }else{
                UserAddress::create($data);
            }
            $user->status = 11;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => "Address information added Successfully",
                'data'=> $user,
                'address'=> $user->address
            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to saved Address information."
            ], 500);
        }
    }

    

    /**
     * @request input formdata
     * api/other-information
    */
    public function saveCoachStepTwo(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'coaching_level'=> 'required',
            //'sport_id'=> 'required',
            'gender_of_coaching'=> 'required',
            'about'=> 'required|max:2500',
            'about_link'=> 'required|max:255',
            'preference_id'=> 'required',
            'user_id'=> 'required',
            'coaching_sport' => 'required'
        ]);
        if ($validator->fails()) {
            $err= $validator->errors();
            $err_msg = '';
            foreach(json_decode($err) as $key=> $val){
                $err_msg = $val[0];
                break;
            }
            return response()->json([
                'success' => false,
                'error' => $err_msg
            ], 422);
        }
        try{
            /*$data = $request->only('coaching_level', 'sport_id',
                'gender_of_coaching', 'about', 'about_link', 'preference_id', 'serve_as_reference', 'user_id');*/
            $data = $request->only('coaching_level',
                'gender_of_coaching', 'about', 'about_link', 'preference_id', 'serve_as_reference', 'user_id', 'coaching_sport','sport_level', 'team_name');
            if($data['coaching_level'] == '2'){
                $data['college_id'] = $request->input('college_id');
            }else{
                $data['coach_level_name'] = $request->input('coach_level_name');
                //$data['school'] = $request->input('school');
            }
             if(!$user = User::find($data['user_id'])){
                return response()->json([
                    'success' => false,
                    'message' => "Unable to process request. User not found"
                ], 200);
            }
            $user_info = CoachInformation::where('user_id', $data['user_id'])->first();
            if(!empty($user_info)){
                CoachInformation::where('user_id', $data['user_id'])->update($data);
            }else{
                CoachInformation::create($data);
            }

            //==Sport==
             $sport_ids = [];
            foreach($sport_id = $request->input('sport_id') as $sport){
                $sport_ids[] = array(
                    'user_id' => $data['user_id'],
                    'sport_id' => $sport,
                );
            }
             if( !empty($sport_ids) ){
                UserSport::where('user_id', $data['user_id'])->delete();
                UserSport::insert($sport_ids);               

            }
    
            $user->status = 12;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => "Other information added Successfully",
                'data'=> $user
            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to saved Other information."
            ], 500);
        }
    }
    /**
     * @request input formdata
    */
    public function saveCoachStepThree(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'sports'=> 'required',
            'user_id'=> 'required'
        ]);
        if ($validator->fails()) {
            $err= $validator->errors();
            $err_msg = '';
            foreach(json_decode($err) as $key=> $val){
                $err_msg = $val[0];
                break;
            }
            return response()->json([
                'success' => false,
                'error' => $err_msg
            ], 422);
        }
        $id = $request->input('user_id');
        try{
            $data['user_id'] = $id;
            if(!$user = User::find($id)){
                return response()->json([
                    'success' => false,
                    'message' => "Unable to process request. User not found"
                ], 200);
            }
            $sport_ids = [];
            $ids = [];
            foreach($sports = $request->input('sports') as $sport){
                $ids[] =  $sport;
                $sport_ids[] = array(
                    'user_id' => $user->id,
                    'sport_id' => $sport,
                );
            }
            if( !empty($sport_ids) ){
                UserSport::where('user_id', $user->id)->delete();

                UserSport::insert($sport_ids);
                $user->status = 13;
                $user->save();
                /**   Get sports positions */
                $sports = Sport::whereIn('id', $ids)
                                                ->get();
                $sport_positions = SportPosition::whereIn('id', $ids)
                                                ->get();
                return response()->json([
                    'success' => true,
                    'message' => "Sports information added Successfully",
                    'data'=> $user,
                    'sports'=> $sports,
                    'sport_positions'=> $sport_positions
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => "Failed to saved Sports information."
                ], 200);
            }
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to saved Sports information."
            ], 500);
        }
    }

    /**
     * @request input formdata
    */
    public function saveCoachStepFour(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'colleges'=> 'required',
            'user_id'=> 'required'
        ]);
        if ($validator->fails()) {
            $err= $validator->errors();
            $err_msg = '';
            foreach(json_decode($err) as $key=> $val){
                $err_msg = $val[0];
                break;
            }
            return response()->json([
                'success' => false,
                'error' => $err_msg
            ], 422);
        }
        $id = $request->input('user_id');
        try{
            if(!$user = User::find($id)){
                return response()->json([
                    'success' => false,
                    'message' => "Unable to process request. User not found"
                ], 200);
            }
            $colleges = [];
            foreach($sports = $request->input('colleges') as $key => $college){
                $colleges[] = array(
                    'user_id' => $user->id,
                    'college_id' => $college,
                );
            }
            if( !empty($colleges) ){
                UserCollege::where('user_id', $user->id)->delete();

                UserCollege::insert($colleges);
                $user->status = 15;
                $user->save();

                return response()->json([
                    'success' => true,
                    'message' => "College added Successfully",
                    'data'=> $user,
                    'colleges'=> $user->colleges
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => "Unable to save data"
                ], 200);
            }
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => "Unable to save data"
            ], 500);
        }
    }

    /**
     * @request input formdata
    */
    public function saveSubscriptionStepFive(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'subscription_id'=> 'required',
            'duration'=> 'required',
            'amount'=> 'required',
            'token'=> 'required',
            'user_id'=> 'required'
        ]);
        if ($validator->fails()) {
            $err= $validator->errors();
            $err_msg = '';
            foreach(json_decode($err) as $key=> $val){
                $err_msg = $val[0];
                break;
            }
            return response()->json([
                'success' => false,
                'error' => $err_msg
            ], 422);
        }
        $id = $request->input('user_id');
        try{
            if(!$user = User::find($id)){
                return response()->json([
                    'success' => false,
                    'message' => "Unable to process request. User not found"
                ], 200);
            }

            $user_info = UserSubscription::where('user_id', $data['user_id'])->first();
            if(!empty($user_info)){
                UserSubscription::where('user_id', $data['user_id'])->update($data);
            }else{
                UserSubscription::create($data);
            }
            $user->status = 1;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => "Subscription saved Successfully. User Registration done.",
                'data'=> $user,
                'subscription'=> $user->subscription,
            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => "Unable to save data"
            ], 500);
        }
    }


     public function updatePassword(Request $request)
    {
        $this->validate($request, array(
            'password'=> 'required',
            'confirm_password'=> 'required',
            'user_id' =>'required'
        ));       

        try{
            $id = $request->input('user_id');
            if(!$user = User::find($id)){
                return response()->json([
                    'success' => false,
                    'message' => "Unable to process request. User not found"
                ], 200);
            }            
            $password = $request->input('password');
            $cpassword = $request->input('confirm_password');

            if($password!= $cpassword){
                return response()->json([
                    'success' => false,
                    'message'=> "Password not match!!"
                ]);
            
            }else{
                $user->password = Hash::make($password); 
                $user->save(); 
                return response()->json([
                'success' => true,
                'message'=> "Password updated successfully",
            ], 200);
            }
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message'=> $e->getMessage()
            ], 200);
        }
    }


    public function coach_level(Request $request)
    {       
        try{
            $data= CoachLevel::all();
            
            return response()->json([
                'success' => true,
                'data'=> $data
            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => true,
                'message' => 'Unable to get request data',
                'data'=> []
            ], 500);
        }
    }

    public function sport_level(Request $request)
    {       
        try{
           
            $data= array(
                array ('id' => '1', 'name' => 'Club'),   array('id' => '2', 'name'=> 'High School'),array('id' => '3', 'name'=> 'College – Division 1'),array('id' => '4', 'name'=> 'College – Division 2'),array('id' => '5', 'name'=> 'College – Division 3'),array('id' => '6', 'name'=> 'Professional')
            );

            return response()->json([
                'success' => true,
                'data'=> $data
            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => true,
                'message' => 'Unable to get request data',
                'data'=> []
            ], 500);
        }
    }

    
    public function yearsCoachingYouthAthletes()
    {
        try{
           
            $years = array();
            $allYears = array();
            for ($i=0; $i <=50 ; $i++) {
               $years['value'] = $i ;
               $allYears [] = $years;
            }
           
            

            return response()->json([
                'success' => true,
                'data'=> $allYears
            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => true,
                'message' => 'Unable to get request data',
                'data'=> []
            ], 500);
        }
    }

    public function primaryAgeGroupyoucurrentlyCoach()
    {
        try{
            
            $currentlyCoach = ['U6 to U9','U10 to U13','U14 to U21','U21 and above','International Competition','Collegiate','Professional'];
            // print_r($currentlyCoach); die;
            $years = array();
            $allYears = array();
            foreach ($currentlyCoach as $coach) {
               $years['ageGroup'] = $coach ;
               $allYears [] = $years;
            }
           
            

            return response()->json([
                'success' => true,
                'data'=> $allYears
            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => true,
                'message' => 'Unable to get request data',
                'data'=> []
            ], 500);
        }
    }


}
