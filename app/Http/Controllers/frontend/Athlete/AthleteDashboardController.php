<?php

namespace App\Http\Controllers\Frontend\Athlete;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserWorkoutLibrary;
use App\Models\WorkoutLibrary;
use App\Models\WorkoutCategory;

use App\Models\UserPhysicalInformation;
use App\Models\UserSportPosition;
use App\Models\Sport;
use App\Models\SchoolPlaying;
use App\Models\UserWorkoutExercises;
use App\Models\UserAciIndex;
use App\Models\UserAciIndexLog;
use App\Models\AciCalculationData;
use App\Models\Events;
use App\Models\VideoEvidence;
use App\Models\Gamehighlight;
use App\Models\Education;
use App\Models\UserSport;
use DB;
use App\Models\Follower;

class AthleteDashboardController extends Controller
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
        $workout_library = UserWorkoutLibrary::where('user_id', Auth()->user()->id)->where('status', 1)->get();
        $workout_librarys = [];
        if(count($workout_library) > 0){
            foreach($workout_library as $key => $val){
                $temp = WorkoutLibrary::where('status', 1)->where('id', $val->workout_library_id)->first();
                if($temp){
                    
                    $cat = WorkoutCategory::where('status', 1)->where('id', $val->workout_id)->first();
                    $temp['category_title'] =  $cat->category_title;
                    $temp['category_id'] =  $cat->id;
                    $workout_librarys[] = $temp;
                }
            }
        }
        
        $user_id= Auth()->user()->id;
        $user_detail=  User::where('id', $user_id)
        ->first();
        $user_physicalInfo=  UserPhysicalInformation::where('user_id', $user_id)
        ->first(); 
        $user_education="";
        if(@$user_physicalInfo->education_id!=""){
            $user_education= Education::where('id', $user_physicalInfo->education_id)->first();
        } 
        $user_sport=UserSport::leftJoin('sports', 'user_sports.sport_id', '=', 'sports.id')->where('user_sports.user_id', $user_id)
        ->get();                           
        
        $user_sportposInfo=  UserSportPosition::where('user_id', $user_id)
        ->first();
        $sport_detail = [];
        if(!empty($user_sportposInfo)){
            $sport_detail=  Sport::where('id', $user_sportposInfo->sport_id)
            ->first(); 
        }
        $school_level = [];
        if(!empty($user_sportposInfo)){
            $school_level=  SchoolPlaying::where('id', $user_sportposInfo->school_level_id)
            ->first();
        }

        $allWorkoutCategory = WorkoutCategory::where('status', 1)->orderBy('is_aci_index', 'desc')->get();
        

        $aci_score = UserAciIndex::where('user_id', Auth()->user()->id)->first();

        
        $video_evidence = VideoEvidence::where('status', 1)->where('user_id', Auth()->user()->id)->get();

        $game_highlight = Gamehighlight::where('status', 1)->where('user_id', Auth()->user()->id)->get();       

        

        $upcoming_event= DB::select("SELECT * FROM  events  WHERE (start_date >= '".date('Y-m-d')."' AND  end_date >= '".date('Y-m-d')."' AND `user_id` = '".Auth()->user()->id."') OR  (start_date <= '".date('Y-m-d')."' AND  end_date >= '".date('Y-m-d')."' AND `user_id` = '".Auth()->user()->id."')  AND `status` =1");

        $last_attend_event= DB::select("SELECT * FROM  events  WHERE (start_date <= '".date('Y-m-d')."' AND  end_date <= '".date('Y-m-d')."')  AND `user_id` = '".Auth()->user()->id."' AND `status` =1");


        
        /**
         * Calculate log records
        */
        
        $all_month = array('1','2','3','4','5','6','7','8','9','10','11','12');

        $months = [];
        $temp = [];
        $month = time();
        for ($i = 2; $i <= 12; $i++) {
        $month = strtotime('last month', $month);
        $temp['month'] = date("m", $month);
        $temp['year'] = date("Y", $month);
        $months[] = $temp;
        }
        $months1[13]['month'] = date("m", time());
        $months1[13]['year'] = date("Y", time());
       
        $months = array_reverse($months);
        $months = array_merge($months,$months1);
       
        $temp = array();
        $all_aci_value_old = array();
        
        $score_dataset = array();
        foreach ($months as $single_month) {
            // print_r($single_month); die;
          if(!empty($single_month)){
            // if(date('m') >= $single_month){

            $all_val = UserAciIndexLog::where('user_id', Auth()->user()->id)->whereYear( 'created_at', $single_month['year'])->whereMonth( 'created_at', $single_month['month'])->orderBy('aci_index', 'desc')->take(1)->get();
            // echo $single_month;
            // echo "<pre>";
            // print_r($all_val);
                //  $count_val = count($all_val);
            // echo $count_val;exit;

                // foreach($all_val as $v){
                //     $all_aci_value_old[] = $v->aci_index;                    
                // }
                // $all_aci_value_old_total = array_sum($all_aci_value_old);
                // //echo $all_aci_value_old_total;exit;
            
                // $temp['value'] = '';

                // if($count_val!=0){
                //     $temp['value'] = $all_aci_value_old_total != 0 ? $all_aci_value_old_total/$count_val : 0 ;

                // }
            if(count($all_val) != 0){
                $temp['value'] = $all_val[0]['aci_index'];
            }
            else{
                $temp['value'] = 0;
            }
            

            $monthNum = $single_month['month'];
            $temp['month'] = date("M", mktime(0, 0, 0, $monthNum, 10));
                // $temp['count_val'] = $count_val;
        }
        $score_dataset[] = $temp;
        
        
    }
        // print_r($all_aci_value);
        // die;
		// print_r(array_shift($temp));
		// $data['final_view_count'] = json_encode($temp);

    
        // echo "<pre>";

        // $all_aci_score = UserAciIndexLog::where('user_id', Auth()->user()->id)->get();
        // print_r($all_aci_score);
        // $temp_score_dataset = array();
        // $score_dataset = array();
        // if($all_aci_score){
        //     foreach($all_aci_score as $key => $val){
        //         $months = date('M', strtotime($val->created_at));
        //         $temp_score_dataset[$months][] = $val->aci_index;
        //     }
        // // print_r($temp_score_dataset);
        // // die;
        //     if(!empty($temp_score_dataset)){
        //         foreach($temp_score_dataset as $k => $v){
        //             $score_dataset[] = array(
        //                 'value' =>array_sum($v)/count($v),
        //                 'month'=> $k
        //             );
        //         }
        //     }
        // }


        // $temp_score_dataset = array();
        // $score_dataset = array();
        // if($all_aci_score){
        //     foreach($all_aci_score as $key => $val){
        //         $months = date('M', strtotime($val->created_at));
        //         $temp_score_dataset[$months][] = $val->aci_index;
        //     }
        // // print_r($temp_score_dataset);
        // // die;
        //     if(!empty($temp_score_dataset)){
        //         foreach($temp_score_dataset as $k => $v){
        //             $score_dataset[] = array(
        //                 'value' =>array_sum($v)/count($v),
        //                 'month'=> $k
        //             );
        //         }
        //     }
        // }
        
        
        // print_r($score_dataset);
        // die;
        //Recommendation
    $recommended_coach_list =DB::table('recommendation')
    ->leftjoin('users','recommendation.receiver_id', '=', 'users.id')

    ->leftJoin('user_address','users.id', '=', 'user_address.user_id')

    ->leftJoin('countries','countries.id', '=', 'user_address.country_id')

    ->select('recommendation.id as recommend_id','recommendation.recommendation','recommendation.created_at','recommendation.receiver_id as coach_id','users.username','users.profile_image',
        'countries.name as country_name')
    ->whereIn('recommendation.recommend_status', [1,3])
        // ->where('recommendation.recommend_status', 1)
    ->where('recommendation.status', 0)
    ->where('recommendation.sender_id', $user_id)
    ->orderBy('recommendation.id', 'DESC')
    ->groupBy('users.id')->limit(3)
    ->get();  

    $aci_rank = $this->aciRankCalculate();

    $follower = Follower::where('follower_id', Auth()->user()->id)->where('status', 2)->get();
    $following = Follower::where('user_id', Auth()->user()->id)
    ->where('status', 2)->get();
    $coach_request= Follower::leftJoin('users', 'followers.user_id', '=', 'users.id')
    ->where('users.role_id',2)
    ->where('followers.follower_id',Auth()->user()->id)
    ->get();
    

    
    return view('frontend.athlete.dashboard.index')
    ->with('workout_librarys', $workout_librarys)
    ->with('user_detail', $user_detail)
    ->with('user_physicalInfo', $user_physicalInfo)
    ->with('sport_detail', $sport_detail)
    ->with('aci_score', $aci_score)
    ->with('school_level', $school_level)       
    ->with('video_evidence', $video_evidence)       
    ->with('game_highlight', $game_highlight)        
    ->with('last_attend_event', $last_attend_event)      
    ->with('score_dataset', $score_dataset)
    ->with('upcoming_event', $upcoming_event)
    ->with('user_education', $user_education)
    ->with('recommended_coach_list', $recommended_coach_list)
    ->with('aci_rank', $aci_rank)
    ->with('follower', $follower)
    ->with('following', $following)
    ->with('coach_request', $coach_request)
    ->with('user_sport', $user_sport)
    ->with('user_sportposInfo', $user_sportposInfo)
    ->with('allWorkoutCategory', $allWorkoutCategory);
}

public function logout() {
    Session::flush();
    Auth::logout();  
    return redirect('/')->with('success','User Logout Successfully');
}

public function changePassword()
{ 
    return view('frontend.change-password');
}   

public function updatePassword(Request $request)
{  
    $id= Session::get('user')['userId'];  
    $user = User::find( $id );    

    $new_pwd = $request->input('new_password');
    $confirm_pwd = $request->input('confirm_password');
    $user->password = Hash::make($new_pwd);        
    $data = $request->all();

    if($new_pwd!= $confirm_pwd){
        return back()->with('error','Password not match!!');
    }

    if(!\Hash::check($data['old_password'], auth()->user()->password)){        

        return back()->with('error','You have entered wrong password');

    }else{  
        $user->save();   
        return back()->with('success','Password Updated successfully!!');
    }
}


    

    /***Update Bio****/
    public function updateBio(Request $request){
        $userId= Auth()->user()->id;
       

        $request->validate([
            'bio' => 'required',

        ]);

        $user = User::find( $userId );        
        $user->bio = $request->input('bio');  


        if($user->save()){
            return back()->with('success', 'Bio Updated Successfully');

        }else{
            return back()->with('error', 'Failed to update information');

        }

    }



    /*******/

    /**
     * Get 
    */
    public function aciRankCal(){
        // echo "h"; die;
        $aci_workout = WorkoutCategory::where(['status'=> 1, 'is_aci_index'=> 1])->first();
        $aci_workout_library = [];
        if($aci_workout){
            $aci_workout_library = UserWorkoutLibrary::where('user_id', Auth()->user()->id)
            ->where('workout_id', $aci_workout->id)
            ->where('status', 1)
            ->get();
            // echo (count($aci_workout_library)); die;
            if(count($aci_workout_library) >= 10){
                $strength_aci = $this->getStrengthACI(Auth()->user());
                $speed_aci = $this->getSpeedACI(Auth()->user());
                $explosiveness_aci = $this->getExplosivenessACI(Auth()->user());
                $agility_aci = $this->getAgilityACI(Auth()->user());
                $endurance_aci = $this->getEnduranceACI(Auth()->user());

                $aci_index = (float)$strength_aci + (float)$speed_aci + (float)$explosiveness_aci + (float)$agility_aci + (float)$endurance_aci;
                $aci_array = array(
                    'user_id'=> Auth()->user()->id,
                    'strength_aci'=> (float)$strength_aci,
                    'speed_aci'=> (float)$speed_aci,
                    'explosivness_aci'=> (float)$explosiveness_aci,
                    'agility_aci'=> (float)$agility_aci,
                    'endurance_aci'=> (float)$endurance_aci,
                    'aci_index'=>  round($aci_index, 2)
                );
                if(UserAciIndex::where('user_id', Auth()->user()->id)->first()){
                    UserAciIndex::where('user_id', Auth()->user()->id)->update($aci_array);
                }else{
                    UserAciIndex::create($aci_array);
                }

                UserAciIndexLog::create($aci_array);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Success',
                    'data'  => array(
                        'aci_index'=> round($aci_index, 2),
                        'strength_aci'=> $strength_aci,
                        'speed_aci'=> $speed_aci,
                        'explosiveness_aci'=> $explosiveness_aci,
                        'agility_aci'=> $agility_aci,
                        'endurance_aci'=> $endurance_aci,
                    )
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'You must select all ACI category to calculate the result'
                ], 200);
            }

        }else{
            return response()->json([
                'success' => false,
                'message' => 'You must select all ACI category to calculate the result',
            ], 200);
        }
    }

    public function aciindexcalculate_value()
    {

        $aci_workout = WorkoutCategory::where(['status'=> 1, 'is_aci_index'=> 1])->first();

        $aci_workout_library = [];
        if($aci_workout){
            $aci_workout_library = UserWorkoutLibrary::where('user_id', Auth()->user()->id)
            ->where('workout_id', $aci_workout->id)
            ->where('status', 1)
            ->get();
            if(count($aci_workout_library) >= 10){
                $strength_aci = $this->getStrengthACI(Auth()->user());
                $speed_aci = $this->getSpeedACI(Auth()->user());
                $explosiveness_aci = $this->getExplosivenessACI(Auth()->user());
                $agility_aci = $this->getAgilityACI(Auth()->user());
                $endurance_aci = $this->getEnduranceACI(Auth()->user());

                $aci_index = (float)$strength_aci + (float)$speed_aci + (float)$explosiveness_aci + (float)$agility_aci + (float)$endurance_aci;
                $aci_array = array(
                    'user_id'=> Auth()->user()->id,
                    'strength_aci'=> (float)$strength_aci,
                    'speed_aci'=> (float)$speed_aci,
                    'explosivness_aci'=> (float)$explosiveness_aci,
                    'agility_aci'=> (float)$agility_aci,
                    'endurance_aci'=> (float)$endurance_aci,
                    'aci_index'=>  round($aci_index, 2)
                );
                if(UserAciIndex::where('user_id', Auth()->user()->id)->first()){
                    UserAciIndex::where('user_id', Auth()->user()->id)->update($aci_array);
                }else{
                    UserAciIndex::create($aci_array);
                }

                UserAciIndexLog::create($aci_array);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Success',
                    'data'  => array(
                        'aci_index'=> round($aci_index, 2),
                        'strength_aci'=> $strength_aci,
                        'speed_aci'=> $speed_aci,
                        'explosiveness_aci'=> $explosiveness_aci,
                        'agility_aci'=> $agility_aci,
                        'endurance_aci'=> $endurance_aci,
                    )
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'You must select all ACI category to calculate the result'
                ], 200);
            }

        }else{
            return response()->json([
                'success' => false,
                'message' => 'You must select all ACI category to calculate the result',
            ], 200);
        }
    }

    public function aciRankCalculate()
    {
        
     $user_id= Auth()->user()->id;
     $user_detail=  User::where('id', $user_id)->first();
     
     $user_index_rank =DB::table('user_aci_indexs')
     ->select('user_aci_indexs.aci_index')
     ->where('user_id', $user_id )
     ->first();

     

     if(!empty($user_index_rank)){
      
         $all_user_workout_list =DB::table('user_aci_indexs')
         ->join('users','user_aci_indexs.user_id', '=', 'users.id')
         ->select('user_aci_indexs.aci_index')
         ->where('users.gender', $user_detail->gender )
         ->where('users.year',  $user_detail->year)
         ->where('users.status','!=', 0)
         ->orderBy('user_aci_indexs.aci_index', 'desc')
         ->get();

         $total_aci_index = array();
         foreach ($all_user_workout_list as $row) {
            $total_aci_index[] = $row->aci_index;
        }

        $total_user = count($all_user_workout_list);

        $my_index = array_search($user_index_rank->aci_index,$total_aci_index,true);
        $my_index = $my_index+1;
        
        $all_result = (($total_user - $my_index ) / $total_user)*100;
        return $all_result;
        
    }
    else{
        return 0;
    }

    
    
    
}

private function manageAciDataIntoModel($data, $x){
    if($uset_index = UserAciIndex::where('user_id', $data['user_id'])->first()){
        $data['aci_index'] = $uset_index->aci_index + $x;
        UserAciIndex::where('user_id', $data['user_id'])->update($data);
    }else{
        $data['aci_index'] = $x;
        UserAciIndex::create($data);
    }
}

private function getUserExceriseValue($workout_library_id, $user_id){        
    $category_id = 8;
    return UserWorkoutExercises::where('category_id', $category_id)
    ->where('workout_library_id', $workout_library_id)
    ->where('user_id', $user_id)
    ->first();
}

private function getStrengthACI($user){
    $x = 0;
    $to_kg = 2.20462;
    $bench_press_id = 6;
    $bp = 0;
    $squat_id = 7;
    $sqt = 0;
    $dead_lift_id = 10;
    $dl = 0;
    $res = 0;
        //get user physical 
    $user_info = UserPhysicalInformation::where('user_id', $user->id)->first();
    if($user_info){
        $bw = (float)$user_info->weight / $to_kg;
        $bench_press = $this->getUserExceriseValue($bench_press_id, $user->id);
        if($bench_press){
            $bp = (float)$bench_press->unit_1 / $to_kg;
        }
        $squat = $this->getUserExceriseValue($squat_id, $user->id);
        if($squat){
            $sqt = (float)$squat->unit_1 / $to_kg;
        }
        $dead_lift = $this->getUserExceriseValue($dead_lift_id, $user->id);
        if($dead_lift){
            $dl = (float)$dead_lift->unit_1 / $to_kg;
        }

            //echo $bw.'+'.$bp.'+'.$sqt.'+'.$dl;
        $x = (float)$bp+$sqt+$dl;
        
        
        if(strtolower($user->gender) == 'male'){
            $res = ( $x * 500) / ((-216.0475144) + (16.2606339 * $bw) + (-0.002388645 * (pow($bw, 2))) + (-0.00113732 * (pow($bw, 3))) + (0.00000701863 * (pow($bw, 4))) + (-0.00000001291 * (pow($bw, 5)))) / 59;
        }else{
            $res =( $x*500)/((594.31747775582+(-27.23842536447*$bw)+(0.82112226871*(pow($bw,2)))+(-0.00930733913*(POW($bw,3)))+(0.00004731582*(POW($bw,4)))+(-0.00000009054*(POW($bw,5)))))/59;
        }

        $data = array(
            'user_id' => $user->id,
            'strength_aci'=> $res
        );

            // if($uset_index = UserAciIndex::where('user_id', $user->id)->first()){
            //     $data['aci_index'] = $uset_index->aci_index + $x;
            //     UserAciIndex::where('user_id', $user->id)->update($data);
            // }else{
            //     $data['aci_index'] = $x;
            //     UserAciIndex::create($data);
            // }
            //$this->manageAciDataIntoModel($data, $x);
    }
    return round($res, 4);
}
    //pass
private function getSpeedACI($user){
    $x = 0;
    $a = 43;
    $yd = 0;
    $b = 44;
    $md = 0;
    $yard_dash = $this->getUserExceriseValue($a, $user->id);
    if($yard_dash){
        $gender = $user->gender == 'male' ? 'm' : 'f';
        // $xx = AciCalculationData::where('aci_component', '40 yard dash')
        $xx = AciCalculationData::where('aci_component', '40 Yard Dash')
        
        ->where('key', $yard_dash->unit_1)
        ->where('user_type', $gender)
        ->first();
        if($xx){
            $yd = !empty($xx->value) ? $xx->value : 0;
        }

    }
    $meter_dash = $this->getUserExceriseValue($b, $user->id);
    if($meter_dash){
        $gender = $user->gender == 'male' ? 'm' : 'f';
        // $xx = AciCalculationData::where('aci_component', '100m yard dash table')
        $xx = AciCalculationData::where('aci_component', '100m Yard Dash')
        ->where('key', $meter_dash->unit_1)
        ->where('user_type', $gender)
        ->first();
        if($xx){
            $md = !empty($xx->value) ? $xx->value : 0;
        }

    }

    $x = (float)trim($yd) + (float)trim($md);
    $data = array(
        'user_id' => $user->id,
        'speed_aci'=> $x
    );
        //$this->manageAciDataIntoModel($data, $x);
    return round($x, 4);
}
    //pass
private function getExplosivenessACI($user){
    $x = 0;
    $a = 54;
    $yd = 0;
    $b = 55;
    $md = 0;
    $yard_dash = $this->getUserExceriseValue($a, $user->id);
    if($yard_dash){
        $gender = $user->gender == 'male' ? 'm' : 'f';
        $xx = AciCalculationData::where('aci_component', 'Standing Broad Jump')
        ->where('key', $yard_dash->unit_1)
        ->where('user_type', $gender)
        ->first();
        if($xx ){
            $yd = !empty($xx->value) ? $xx->value : 0;
        }

    }
    $meter_dash = $this->getUserExceriseValue($b, $user->id);
    if($meter_dash){
        $gender = $user->gender == 'male' ? 'm' : 'f';
        $xx = AciCalculationData::where('aci_component', 'Vertical Jump')
        ->where('key', $meter_dash->unit_1)
        ->where('user_type', $gender)
        ->first();
        if($xx ){
            $md = !empty($xx->value) ? $xx->value : 0;
        }

    }
    $x = trim($yd) + trim($md);
    $data = array(
        'user_id' => $user->id,
        'explosivness_aci'=> $x
    );
       // $this->manageAciDataIntoModel($data, $x);
    return round($x, 4);
}
    //pass
private function getAgilityACI($user){
    $x = 0;
    $a = 69;
    $yd = 0;
    $b = 70;
    $md = 0;
    $yard_dash = $this->getUserExceriseValue($a, $user->id);
    if($yard_dash){
        $gender = $user->gender == 'male' ? 'm' : 'f';
        $xx = AciCalculationData::where('aci_component', 'LIKE', '%5-10-5 Drill%')
        ->where('key', $yard_dash->unit_1)
        ->where('user_type', $gender)
        ->first();
        if($xx){
            $yd = !empty($xx->value) ? $xx->value : 0;
        }

    }
    $meter_dash = $this->getUserExceriseValue($b, $user->id);
    if($meter_dash){
        $gender = $user->gender == 'male' ? 'm' : 'f';
        // $xx = AciCalculationData::where('aci_component', 'L Cone Drill')
        $xx = AciCalculationData::where('aci_component', 'LIKE', '%L Cone Drill%')
        
        ->where('key', $meter_dash->unit_1)
        ->where('user_type', $gender)
        ->first();
        if($xx){
            $md = !empty($xx->value) ? $xx->value : 0;
        }

    }
// echo "yd<br>";
// echo $yd;
// echo "md";
// echo $md;
//  die;
    $x = trim($yd) + trim($md);
    $data = array(
        'user_id' => $user->id,
        'agility_aci'=> $x
    );
        //$this->manageAciDataIntoModel($data, $x);
    return round($x, 4);
}
    //pass
private function getEnduranceACI($user){
    $x = 0;
    $a = 76;
    $yd = 0;
    $yard_dash = $this->getUserExceriseValue($a, $user->id);
    if($yard_dash){
        $gender = $user->gender == 'male' ? 'm' : 'f';
        $xx = AciCalculationData::where('aci_component', 'LIKE', '%1 Mile Time%')
        ->where('key', $yard_dash->unit_1)
        ->where('user_type', $gender)
        ->first();
        if($xx){
            $yd = !empty($xx->value) ? $xx->value : 0;
        }

    }

    $x = (float)trim($yd);
    $data = array(
        'user_id' => $user->id,
        'endurance_aci'=> $x
    );
        //$this->manageAciDataIntoModel($data, $x);
    return round($x, 4);
}

public function getDescription(Request $request){
 
   $data['res'] = DB::table('game_highlights')->where('id', $request->game_id)->get();
   return response()->json($data);        
}

    //==Coach Request==
public function coachRequest(){
    $coach_request= Follower::leftJoin('users', 'followers.user_id', '=', 'users.id')
    ->select('users.id','followers.id as fid','followers.user_id')
    ->where('users.role_id',2)
    ->where('followers.follower_id',Auth()->user()->id)
    ->where('followers.status', 1)
    ->get();

    return view('frontend.athlete.follow.coach-request')
    ->with('coach_request', $coach_request);
}

public function requestResponse(Request $request){
    $follower_id = $request->follower_id;

    $status= $request->status;

    if($status==2){
        $message="Accepted";
    }else{
        $message="Rejected";
    }
    $res = Follower::where('id', $follower_id)
    ->first();
    $res->status = $status;
    if($res->save()){
        return response()->json([
            'success' => true,
            'message' => $message
        ], 200);
    }

}


}