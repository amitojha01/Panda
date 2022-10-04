<?php

namespace App\Http\Controllers\Auth;

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
use App\Models\UserSport;
use App\Models\SchoolPlaying;
use App\Models\College;
use App\Models\UserSportPosition;
use App\Models\UserCollege;
use App\Models\UserAddress;
use App\Models\CoachInformation;
use App\Models\GuardianInformation;
use App\Models\State;
use App\Models\CoachLevel;
use DB;


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
    public function getRegistration()
    {
        return view('frontend.register.steps');
    }

    public function getStepOne($type)
    {
        return view('frontend.register.step-2')->with('type', $type);
    }

    /**
     * @request email[string]
     * @response json[success, email-status, status]
    */
    public function getVerifyMobile(Request $request)
    {
        $data = $request->only('mobile');
        $validator = Validator::make($data, [
            'mobile' => 'required',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->messages()
            ], 422);
        }
        $otp = mt_rand(1111, 9999);
        try{
            $getUser = User::where($data)->where('status', '!=', 9)->first();
            if(!empty($getUser)){
                return response()->json([
                    'success' => false,
                    'message'=> "Sorry!! Mobile is already registered"
                ]);
            }
            $data['otp'] = $otp;
            /*
                ** integrate sms getway here with API
            */
            return response()->json([
                'success' => true,
                'message'=> "Please check your mobile for OTP",
                'data'=> array(
                    'otp' => base64_encode($otp)
                )
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message'=> $e->getMessage()
            ], 200);
        }
    }

    /**
     * verify user[user, other]
    */
    public function getVerifyEmail(Request $request)
    {
        $data = $request->only('email', 'verify_user');
        $validator = Validator::make($data, [
            'email' => 'required|email',
            'verify_user'   => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->messages()
            ], 422);
        }
        $otp = mt_rand(1111, 9999);
        try{
            /**------- Validate below code only for user */
            if($request->input('verify_user') == 'user'){
                $data = $request->only('email');
                $getUser = User::where($data)->where('status', '!=', 9)->first();
                if(!empty($getUser)){
                    return response()->json([
                        'success' => false,
                        'message'=> "Sorry!! Email is already registered"
                    ]);
                }
            }

            $data['otp'] = $otp;
            Mail::to($data['email'])->send(new EmailVerification($data));
            return response()->json([
                'success' => true,
                'message'=> "Please check your email for OTP",
                'data'=> array(
                    'otp' => base64_encode($otp)
                )
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message'=> $e->getMessage()
            ], 200);
        }
    }

    public function saveStepOne(Request $request, $type)
    {
        $this->validate($request, array(
            'username' => 'required|unique:users,username',
            'password'=> 'required|min:8',
            'email'=> 'required|unique:users,email',
            'mobile'=> 'required|unique:users,mobile',
            'gender'=> 'required',
            'year'=> 'sometimes|required',
            'month'=> 'sometimes|required',
            'day'=> 'sometimes|required',
        ));
        try{
            $data = $request->only('username', 'password', 'email', 'mobile', 'gender', 'day', 'month', 'year', 'profile_type');
            $data['password'] = Hash::make($data['password']);
            $data['status'] = 10;
            $data['role_id'] = $type == "athlete"? 1 : 2;
            if($user = User::create($data)){
                session(['user' => $user, 'password'=> $request->input('password')]);
                // return redirect('registration/'. $type .'/step-2')->with('success','Step 1 completed Successfully');
                //get yesr -12 years 2012 2013
                if($data['role_id'] == 1){
                $get_year = (date('Y')-12);
                    if($data['year'] >= $get_year){
                        return redirect('registration/'.$type.'/step-guardian')->with('success','Basic information saved Successfully');
                    }else{
                        return redirect('registration/'.$type.'/step-1')->with('success','Basic information saved Successfully');
                    }
                }else{
                    return redirect('registration/'.$type.'/step-1')->with('success','Basic information saved Successfully');
                    }
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
     * Guardian Info step
    */
    public function getGuardianInfoStep($type)
    {
        return view('frontend.register.athlete.step-guardian-info')->with('type', $type);
    }

    public function saveGuardianInfoStep(Request $request)
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
            'secondary_phone'=> 'required',
            'secondary_phone_type'=> 'required',
            'is_secondary_text'=> 'required',
            'primary_email'=> 'required'
        ));
        try{
            $user = session('user');
            $data = $request->only('relationship', 'first_name', 'last_name', 'enable_textmessage', 'primary_phone', 'primary_phone_type', 'is_primary_text', 'secondary_phone', 'secondary_phone_type', 'is_secondary_text', 'primary_email');
            $data['user_id'] = $user->id;
            if(!$user = User::find($user->id)){
                return redirect('/')->with('error','Unable to process request 1');
            }

            if(!empty(GuardianInformation::where('user_id', $user->id)->first())){
                GuardianInformation::where('user_id', $user->id)->update($data);
            }else{
                GuardianInformation::create($data);
            }

            return redirect('registration/athlete/step-1')->with('success','Guardian information saved Successfully');
        }
        catch(\Exception $e)
        {
            return back()->with('error','Unable to save data');
        }
    }
    /**
     * Update user table for address informations
    */
    public function getAddressStep($type)
    {
        $states = State::where('country_id', '231')->get();
        return view('frontend.register.step-2-address')->with('type', $type)
        ->with('states', $states);
    }

    /**
     * @request input formdata
    */
    public function saveAddressStep(Request $request, $type)
    {
        $this->validate($request, array(
            'country_id'=> 'required',
            'state_id'=> 'required',
            'city_id'=> 'required',
            // 'zip'=> 'required'
        ));
        $user = session('user');
        try{
            $data = $request->only('country_id', 'state_id', 'city_id', 'zip');
            // dd($data);
            $data['user_id'] = $user->id;
            if(!$user = User::find($user->id)){
                return redirect('/')->with('error','Unable to process request 1');
            }

            UserAddress::create($data);
            $user->status = 11;
            $user->save();
            if( $type == "athlete"){
                return redirect('registration/athlete/step-2')->with('success','Address information added Successfully');
            }else{
                return redirect('registration/coach/other-information')->with('success','Address information added Successfully');
            }
        }
        catch(\Exception $e)
        {
            return back()->with('error','Unable to save data');
        }
    }
    /**
     * athlete next step to complete physical informations
     * @return view
    */
    public function getAthleteStepTwo()
    {
        return view('frontend.register.athlete.step-3');
    }

    /**
     * @request input formdata
    */
    public function saveAthleteStepTwo(Request $request)
    {
        $this->validate($request, array(
            'height_feet'=> 'required',
            'height_inch'=> 'required',
            'weight'=> 'required',
            'wingspan_feet'=> 'required',
            'wingspan_inch'=> 'required',
            'head'=> 'required',
            'education_id'=> 'required',
            'grade'=> 'required'
        ));
        $user = session('user');
        try{
            $data = $request->only('height_feet', 'height_inch', 'weight', 'wingspan_feet', 'wingspan_inch', 'head', 'education_id', 'grade');
            $data['user_id'] = $user->id;
            if(!$user = User::find($user->id)){
                return redirect('/')->with('error','Unable to process request');
            }
            $user_info = UserPhysicalInformation::where('user_id', $user->id)->first();
            if(!empty($user_info)){
                UserPhysicalInformation::where('user_id', $user->id)->update($data);
            }else{
                UserPhysicalInformation::create($data);
            }
            $user->status = 12;
            $user->save();

            return redirect('registration/athlete/step-3')->with('success','Physical Informations added Successfully');
        }
        catch(\Exception $e)
        {
            return back()->with('error','Unable to save data');
        }
    }

    /**
     * athlete next step to complete physical informations
     * @return view
    */
    public function getAthleteStepThree()
    {
        $data = Sport::where('status', 1)->get();
        return view('frontend.register.athlete.step-4')
                    ->with('sports', $data);
    }

    /**
     * @request input formdata
    */
    public function saveAthleteStepThree(Request $request)
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
                $user->status = 13;
                $user->save();

                return redirect('registration/athlete/step-4')->with('success','Sports selection saved Successfully');
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
     * athlete next step to complete physical informations
     * @return view
    */
    public function getAthleteStepFour()
    {
        $user = session('user');
        $suer_sports = UserSport::where('user_id', $user->id)->get()->pluck('sport_id');
        $sports = Sport::whereIn('id', $suer_sports)
                ->get();
        $playingLevels = SchoolPlaying::where(['status'=> 1])->get();

        $clubs = College::where(['status'=> 1, 'type'=> 3])->get();
        //dd($sports);
        return view('frontend.register.athlete.step-5')
                    ->with('sports', $sports)
                    ->with('clubs', $clubs)
                    ->with('playingLevels', $playingLevels);
    }

    /**
     * @request input formdata
    */
    public function saveAthleteStepFour(Request $request)
    {
        $this->validate($request, array(
            'sport_positions'=> 'required',
            'competition_level_id'=> 'required',
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
                    'competition_id'=> $request->input('competition_level_id'),
                    'school_level_id'=> $request->input('school_level_id'),
                    'other_level_id'=> $request->input('other_level_id'),
                );
            }
            if( !empty($sport_ids) ){
                UserSportPosition::where('user_id', $user->id)->delete();

                UserSportPosition::insert($sport_ids);
                $user->status = 14;
                $user->save();

                return redirect('registration/athlete/step-5')->with('success','Sports position saved Successfully');
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
     * athlete next step to complete physical informations
     * @return view
    */
    public function getAthleteStepFive()
    {
        $user = session('user');
        $colleges = College::where(['status'=> 1, 'type'=> 1])->get();
        //dd($sports);
        return view('frontend.register.athlete.step-6')
                    ->with('colleges', $colleges);
    }

    /**
     * @request input formdata
    */
    public function saveAthleteStepFive(Request $request)
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
                $user->status = 15;
                $user->save();

                return redirect('registration/athlete/step-6')->with('success','College informations saved Successfully');
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
     * athlete next step to complete physical informations
     * @return view
     * Basically Subscription for User profile
    */
    public function getAthleteStepSix()
    {
        if(!session('user')){
            return redirect('/')->with('error','Unable to process request');
        }

        return view('frontend.register.athlete.step-7');
    }

    /**
     * @request input formdata
    */
    public function redirectDashboard(Request $request)
    {
        if(!session('user')){
            return redirect('/')->with('error','Unable to process request');
        }
        $credentials = array(
            'email' => session('user')->email,
            'password' => session('password')
        );
        if (Auth::attempt($credentials)) {
            return redirect()->intended('athlete/dashboard')
                        ->with('success','Login success');
        }

        return redirect('/')->with('error','Unable to process request');
    }

    //Coach section
    /**
     * Coach next step to complete physical informations
     * @return view
    */
    /**
     * 
    */
    public function getOtherInformationStep()
    {
        $coach_level= CoachLevel::all();
        return view('frontend.register.coach.step-3')
        ->with('coach_level', $coach_level);
    }

    public function saveOtherInformationStep(Request $request)
    {
        $this->validate($request, array(
            'coaching_level'=> 'required',
            'sport_id'=> 'required',
            'gender_of_coaching'=> 'required',
            'about'=> 'required|max:2500',
            'about_link'=> 'required|max:255',
            'preference_id'=> 'required'
        ));
        $user = session('user');
        try{
           
            $data = $request->only('coaching_level', 'sport_id',
                'gender_of_coaching', 'about', 'about_link', 'preference_id', 'serve_as_reference');
            //echo $data['coaching_level'];exit;
            if($data['coaching_level'] == '2'){
                $data['college_id'] = $request->input('college_id');
            }else{
                $data['school'] = $request->input('school');
            }
            if(!$user = User::find($user->id)){
                return redirect('/')->with('error','Unable to process request');
            }
            $user_info = CoachInformation::where('user_id', $user->id)->first();
            if(!empty($user_info)){
                CoachInformation::where('user_id', $user->id)->update($data);
            }else{
                $data['user_id'] = $user->id;
                CoachInformation::create($data);
            }
            $user->status = 12;
            $user->save();

            return redirect('registration/coach/step-2')->with('success','Other Information saved Successfully');
        }
        catch(\Exception $e)
        {
            return back()->with('error','Unable to save data');
        }
    }

    public function getCoachStepThree()
    {
        $data = Sport::where('status', 1)->get();
        return view('frontend.register.coach.step-4')
                    ->with('sports', $data);
    }

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

                return redirect('registration/coach/step-5')->with('success','Sports saved Successfully');
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

                return redirect('registration/coach/step-6')->with('success','College data saved successfully Successfully');
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

    //==6nov==

    

     function getCollege(Request $request)
    {
     if($request->get('query'))
     {
      $query = $request->get('query');
      $data = DB::table('colleges')
        ->where('name', 'LIKE', "%{$query}%")
        ->get();
      $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
      foreach($data as $row)
      {
       $output .= '
       <li><a href="#">'.$row->name.'</a></li>
       ';
      }
      $output .= '</ul>';
      echo $output;
     }
    }

}
