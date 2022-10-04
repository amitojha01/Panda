<?php

namespace App\Http\Controllers\Api\Athlete;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;

use App\Models\User;
use App\Models\UserPhysicalInformation;
use App\Models\Sport;
use App\Models\SportPosition;
use App\Models\UserSport;
use App\Models\SchoolPlaying;
use App\Models\College;
use App\Models\UserSportPosition;
use App\Models\UserCollege;
use App\Models\UserAddress;
use App\Models\UserSubscription;
use App\Models\GuardianInformation;

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
            'year'=> 'required',
            'month'=> 'required',
            'day'=> 'required',
            'graduation_year'=> 'required',
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
            $data = $request->only('username', 'password', 'email', 'mobile', 'gender', 'year', 'month', 'day', 'graduation_year','profile_type');
            $data['password'] = Hash::make($data['password']);
            $data['status'] = 10;
            $data['role_id'] = 1;
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
     * Save guardian information if logged in users age <=12
    */
    public function saveGuardianInfo(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'relationship' => 'required',
            'first_name'=> 'required',
            'last_name'=> 'required',
            'enable_textmessage'=> 'required',
            'primary_phone'=> 'required',
            'primary_phone_type'=> 'required',
            'is_primary_text'=> 'required',
            'secondary_phone'=> 'required',
            'secondary_phone_type'=> 'required',
            'is_secondary_text'=> 'required',
            'primary_email'=> 'required',
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
            $data = $request->only('relationship', 'first_name', 'last_name', 'enable_textmessage', 'primary_phone', 'primary_phone_type', 'is_primary_text', 'secondary_phone', 'secondary_phone_type', 'is_secondary_text', 'primary_email', 'user_id');
            $id = $request->input('user_id');
            if(!$user = User::find($id)){
                return response()->json([
                    'success' => false,
                    'message' => "Unable to process request. User not found",
                    'error' =>'',
                ], 200);
            }

            if(!empty(GuardianInformation::where('user_id', $id)->first())){
                GuardianInformation::where('user_id', $id)->update($data);
            }else{
                GuardianInformation::create($data);
            }

            return response()->json([
                'success' => true,
                'message' => "Guardian information added Successfully",
                'data'=> [],
                'error' =>'',
            ], 200);
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
                    'message' => "Unable to process request. User not found",
                    'error' =>'',
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
                'address'=> $user->address,
                'error' =>'',
            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to saved Address information.",
                'error' =>'',
            ], 500);
        }
    }

    /**
     * @request input formdata
    */
    public function saveAthleteStepTwo(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'height_feet'=> 'required',
            'height_inch'=> 'required',
            'weight'=> 'required',
            'wingspan_feet'=> 'required',
            'wingspan_inch'=> 'required',
            'head'=> 'required',
            'education_id'=> 'required',
            'grade'=> 'required',
            'user_id'=> 'required',
            'dominant_hand' => 'required',
            'dominant_foot' => 'required',
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
            $data = $request->only('height_feet', 'height_inch', 'weight', 'wingspan_feet', 'wingspan_inch', 'head', 'education_id', 'grade', 'user_id','dominant_hand', 'dominant_foot');
            if(!$user = User::find($data['user_id'])){
                return response()->json([
                    'success' => false,
                    'message' => "Unable to process request. User not found",
                    'error' =>'',
                ], 200);
            }
            $user_info = UserPhysicalInformation::where('user_id', $data['user_id'])->first();
            if(!empty($user_info)){
                UserPhysicalInformation::where('user_id', $data['user_id'])->update($data);
            }else{
                UserPhysicalInformation::create($data);
            }
            $user->status = 12;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => "Physical information added Successfully",
                'data'=> $user,
                'physical_info'=> $user->physicalInfo,
                'error' =>'',
            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to saved Address information.",
                'error' =>'',
            ], 500);
        }
    }
    /**
     * @request input formdata
    */
    public function saveAthleteStepThree(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'sports'=> 'required',
            'user_id'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->messages()
            ], 422);
        }
        $id = $request->input('user_id');
        try{
            $data['user_id'] = $id;
            if(!$user = User::find($id)){
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
                                ->with('positions')
                                ->get();
                $sport_positions = SportPosition::whereIn('sport_id', $ids)
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
    public function saveAthleteStepFour(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'sports'=> 'required',
            'sport_positions'=> 'required',
            'school_level_id'=> 'required',
            'competition_id'=> 'required',
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
            $sport_ids = [];
            $sport_positions = $request->input('sport_positions');
            foreach($sports = $request->input('sports') as $key => $sport){
                $sport_ids[] = array(
                    'user_id' => $id,
                    'sport_id' => $sport,
                    'position_id'=> $sport_positions[$key],
                    'school_level_id'=> $request->input('school_level_id'),
                    'competition_id'=> $request->input('competition_id'),
                    'other_level_id'=> $request->input('other_level_id'),   //Travel/Rcc/Club
                );
            }
            if( !empty($sport_ids) ){
                UserSportPosition::where('user_id', $user->id)->delete();

                UserSportPosition::insert($sport_ids);
                $user->status = 14;
                $user->save();

                return response()->json([
                    'success' => true,
                    'message' => "Sports positions added Successfully",
                    'data'=> $user
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => "Failed to saved Sports positions information."
                ], 200);
            }
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to saved Sports positions information."
            ], 500);
        }
    }
    /**
     * @request input formdata
    */
    public function saveAthleteStepFive(Request $request)
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



    /**
     * @request input formdata
    */


    /**
     * @request input formdata
    */
    public function saveCoachStepThree(Request $request)
    {
        $this->validate($request, array(
            'sports'=> 'required'
        ));
        $user = session('user');
        try{
            $data['user_id'] = $user->id;
            if(!$user = User::find($user->id)){
                return redirect('/')->with('error','Unable to process request');
            }
            $sport_ids = [];
            foreach($sports = $request->input('sports') as $sport){
                $sport_ids[] = array(
                    'user_id' => $user->id,
                    'sport_id' => $sport,
                );
            }
            if( !empty($sport_ids) ){
                UserSport::where('user_id', $user->id)->delete();

                UserSport::insert($sport_ids);
                $user->status = 12;
                $user->save();

                return redirect('registration/coach/step-4')->with('success','Step 3 completed Successfully');
            }else{
                return back()->with('error','Unable to save data');
            }
        }
        catch(\Exception $e)
        {
            return back()->with('error','Unable to save data');
        }
    }

    /**
     * Coach next step to complete physical informations
     * @return view
    */
    public function getCoachStepFour()
    {
        $user = session('user');
        $suer_sports = UserSport::where('user_id', $user->id)->get()->pluck('sport_id');
        $sports = Sport::whereIn('id', $suer_sports)
                ->get();
        $playingLevels = SchoolPlaying::where(['status'=> 1])->get();

        $clubs = College::where(['status'=> 1, 'type'=> 3])->get();
        //dd($sports);
        return view('frontend.register.coach.step-5')
                    ->with('sports', $sports)
                    ->with('clubs', $clubs)
                    ->with('playingLevels', $playingLevels);
    }

    /**
     * @request input formdata
    */
    public function saveCoachStepFour(Request $request)
    {
        $this->validate($request, array(
            'sport_positions'=> 'required',
            'school_level_id'=> 'required',
        ));
        $user = session('user');
        try{
            $data['user_id'] = $user->id;
            if(!$user = User::find($user->id)){
                return redirect('/')->with('error','Unable to process request');
            }
            $sport_ids = [];
            $sport_positions = $request->input('sport_positions');
            foreach($sports = $request->input('sports') as $key => $sport){
                $sport_ids[] = array(
                    'user_id' => $user->id,
                    'sport_id' => $sport,
                    'position_id'=> $sport_positions[$key],
                    'school_level_id'=> $request->input('school_level_id'),
                    'other_level_id'=> $request->input('other_level_id'),
                );
            }
            if( !empty($sport_ids) ){
                UserSportPosition::where('user_id', $user->id)->delete();

                UserSportPosition::insert($sport_ids);
                $user->status = 13;
                $user->save();

                return redirect('registration/coach/step-5')->with('success','Step 4 completed Successfully');
            }else{
                return back()->with('error','Unable to save data');
            }
        }
        catch(\Exception $e)
        {
            return back()->with('error','Unable to save data');
        }
    }

    /**
     * Coach next step to complete physical informations
     * @return view
    */
    public function getCoachStepFive()
    {
        $user = session('user');
        $colleges = College::where(['status'=> 1, 'type'=> 1])->get();
        //dd($sports);
        return view('frontend.register.coach.step-6')
                    ->with('colleges', $colleges);
    }

    /**
     * @request input formdata
    */
    public function saveCoachStepFive(Request $request)
    {
        $this->validate($request, array(
            'colleges'=> 'required'
        ));
        $user = session('user');
        try{
            $data['user_id'] = $user->id;
            if(!$user = User::find($user->id)){
                return redirect('/')->with('error','Unable to process request');
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
                $user->status = 14;
                $user->save();

                return redirect('registration/coach/step-6')->with('success','Step 5 completed Successfully');
            }else{
                return back()->with('error','Unable to save data');
            }
        }
        catch(\Exception $e)
        {
            return back()->with('error','Unable to save data');
        }
    }

    /**
     * Coach next step to complete physical informations
     * @return view
     * Basically Subscription for User profile
    */
    public function getCoachStepSix()
    {
        if(!session('user')){
            return redirect('/')->with('error','Unable to process request');
        }

        return view('frontend.register.coach.step-7');
    }

    /**
     * @request input formdata
    */
    public function redirectCoachDashboard(Request $request)
    {
        if(!session('user')){
            return redirect('/')->with('error','Unable to process request');
        }
        $credentials = array(
            'email' => session('user')->email,
            'password' => session('password')
        );
        if (Auth::attempt($credentials)) {
            return redirect()->intended('coach/dashboard')
                        ->with('success','Login successfull');
        }

        return redirect('/')->with('error','Unable to process request');
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

   
     public function dominant(Request $request)
    {       
        try{
           
            $data= array(
                array ('id' => '1', 'name' => 'Right'),   array('id' => '2', 'name'=> 'Left'),array('id' => '3', 'name'=> 'Ambidextrous')
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




}
