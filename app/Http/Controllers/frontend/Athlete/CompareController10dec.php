<?php

namespace App\Http\Controllers\Frontend\Athlete;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Compare;
use App\Models\CompareGroup;
use App\Models\MemberCompareHeader;
use App\Models\UserWorkoutLibrary;
use App\Models\WorkoutCategoryLibrary;
use App\Models\WorkoutLibrary;
use App\Models\WorkoutCategory;
use App\Models\UserWorkoutExerciseLog;
use App\Models\UserAciIndex;
use App\Models\TeamingGroupUser;
use App\Models\Teaming;
use App\Models\State;
use App\Models\City;
use App\Models\Sport;
use App\Models\SportPosition;
use App\Models\Competition;

use App\Models\UserWorkoutExercises;
use DB;
use Illuminate\Support\Facades\Hash;


class CompareController extends Controller
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
    public function index(Request $request)
    {   
        $user_id= Auth()->user()->id;
        $tabActive ='';
        $search_details = '';
        if(!empty($request->input())){
        $tabActive ='active';    
        $sports = [];
        $position = [];
        $states = '';
        $gender = '';
        $competition = '';
        $sports = $request->input('sports');
        $position = $request->input('position');
        $gender = $request->input('gender');
        $states = $request->input('states');
        $cities = $request->input('cities');
        $start_year = $request->input('start_year');
        $end_year = $request->input('end_year');
        $competition = $request->input('competition');
        // dd($states);
        // $query = User::where('role_id', 1)->where('id', '!=', Auth()->user()->id)->with('address');
        $query =User::join('user_address','user_address.user_id', '=', 'users.id')->join('user_sport_positions','user_sport_positions.user_id', '=', 'users.id')->select('users.*');

        if(!empty($sports)){
            $query = $query->whereIn('sport_id', $sports);
        }
        if(!empty($position)){
            $query = $query->whereIn('position_id', $position);
        }
        if(!empty($gender)){
            $query = $query->where('gender', $gender);
        }
        if(!empty($states)){
            $query = $query->where('state_id', $states);
        }
        if(!empty($cities)){
            $query = $query->where('city_id', $cities);
        }

        if(!empty($start_year)){
            $query = $query->where('date_of_year', '>=', $start_year);
        }
        if(!empty($end_year)){
            $query = $query->where('date_of_year', '<=', $end_year);
        }
        if(!empty($competition)){
            $query = $query->where('competition_id', '<=', $competition);
        }
        $athlete = $query->get();
        
        }else{

        $athlete = User::where('role_id', 1)->where('id', '!=',Auth()->user()->id)
        ->with('address')
        ->get();
        }
        // pr($athlete);
        //saved compaison
        $comparison_group =DB::table('compare_group')
        ->leftjoin('compare','compare_group.id', '=', 'compare.comparison_group_id')

         ->select('compare_group.id','compare_group.comparison_name')->where('compare_group.status', 1)->where('compare.status', 1)->where('compare.user_id', $user_id)->groupBy('compare_group.id')
        ->get();
        $states= State::where('country_id', 231)->get();
        $cities =DB::table('cities')
            ->join('states','states.id', '=', 'cities.state_id')
            ->select('cities.*')
            ->where('states.country_id', 231)
            ->get();
        $sport= Sport::where('status', 1)->get();
        $sport_position= SportPosition::where('status', 1)->get();
        $competition_level= Competition::where('status', 1)->get(); 
        // dd($comparison_group);
         //group list
        
        $group =DB::table('teamingup_group')
        ->leftjoin('teamingup_group_users','teamingup_group.id', '=', 'teamingup_group_users.teaming_group_id')

         ->select('teamingup_group.id','teamingup_group.group_name','teamingup_group.description','teamingup_group.image','teamingup_group.created_by','teamingup_group_users.user_id','teamingup_group_users.is_joined')->where('teamingup_group.created_by', $user_id)->orWhere('teamingup_group_users.user_id', $user_id)->groupBy('teamingup_group.id')
        ->get();

        // new compare model start
        $allWorkoutCategory = WorkoutCategory::where('status', 1)->orderBy('is_aci_index', 'desc')->get(); 
        
        // $allworkCat = [];
        // foreach($allWorkoutCategory as $workOutValue){
        //     echo '<pre>';
        //     // print_r($workOutValue);
        //     // die;
        // $allworkCat['cai_id'] = $workOutValue['id'];
        // $workout_library = WorkoutCategoryLibrary::where('workout_category_id', $workOutValue['id'])->get()->pluck('workout_library_id');
        // print_r($workout_library); die;
        // $data = [];
        //     if(count($workout_library) > 0){
        //         $data = WorkoutLibrary::where('status', 1)->whereIn('id', $workout_library)->get();
        //     }else{
        //         $data = WorkoutLibrary::where('status', 1)->get();
        //     }
        // }
       // dd($group);
        return view('frontend.athlete.compare.index')
        ->with('comparison_group',$comparison_group)
        ->with('group',$group)
        ->with('athlete',$athlete)
        ->with('states', $states)
        ->with('sport', $sport)
        ->with('sport_position', $sport_position)
        ->with('cities', $cities)
        ->with('competition_level', $competition_level)
        ->with('tabActive', $tabActive)
        ->with('allWorkoutCategory', $allWorkoutCategory);
    }

     public function AddAthlete($id='')
    {   
        // dd($id);
        $compareGroupId= $id;
        

        $exits_compare_user = Compare::where('comparison_group_id', $compareGroupId)
        ->get();
        $exits_compare_users = [];
        foreach ($exits_compare_user as $key => $value) {
            $exits_compare_users[] = $value['compare_user_id'];
        }
        $temp = Auth()->user()->id;
         $exits_compare_users[]=$temp;
        $athlete = User::where('role_id', 1)
            ->whereNotIn('id',  $exits_compare_users)
            ->with('address')
            ->get();


        // $group =DB::table('users')
        // ->leftjoin('compare_group','users.id', '=', 'compare_group.user_id')

        //  ->select('users.id','users.username','teamingup_group.image','teamingup_group.created_by','teamingup_group_users.user_id','teamingup_group_users.is_joined')->where('teamingup_group.created_by', $user_id)->orWhere('teamingup_group_users.user_id', $user_id)->groupBy('teamingup_group.id')
        // ->with('address')
        // ->get();

        return view('frontend.athlete.compare.add-athletes')
        ->with('athlete',$athlete);

    }
    public function addCompare(Request $request)
    {   
          $user_id= Auth()->user()->id;
            $CompareId = $request->compare_user_id;
            $data = $request->only('compare_user_id');
            $data['user_id'] = $user_id;
            $exit_compare_user = $athlete = Compare::where('status', 1)->where('user_id', $user_id)->where('compare_user_id', $CompareId)->first();
            if (empty($exit_compare_user)) {
                if(Compare::insert($data)){  
                   return response()->json([
                    'success' => true,
                    'message' => 'added'
                ], 200);
                }
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'already added'
                ], 200);
            }

    }

    public function deleteCompare($id="")
    {
        
        $user_id= Auth()->user()->id;
       $compareId=$id;
       $comparison_group_id = Compare::where('comparison_group_id', $compareId)->get();
       if ($comparison_group_id) {
          foreach ($comparison_group_id as $key => $value) {
             Compare::where('id',$value->id)->delete();
          }
       }
       
       if(CompareGroup::where('id',$compareId)->delete()){            
        // return redirect('/athlete/events')->with('success','Events Deleted Successfully');
        return response()->json([
            'success' => true,
            'data'=> 'Event',
            'message'=>'Data Deleted Succesfully'
        ], 200);
        }else{
            return back()->with('error', 'Failed to delete event');
        }
    }

    public function deleteCompareUser($id="")
    {
        $compare_id= $id;
       if(Compare::where('compare_user_id',$compare_id)->delete()){            
        return response()->json([
            'success' => true,
            'data'=> 'Event',
            'message'=>'Data Deleted Succesfully'
        ], 200);
        }else{
            return back()->with('error', 'Failed to delete event');
        }
    }

    public function compareGroup($value='')
    {
        $user_id = Auth()->user()->id;

        $group_detail = Teaming::whereIn('id', explode(',', $value))->get();
        
         $groupmember =DB::table('teamingup_group_users')
        ->leftjoin('users','teamingup_group_users.user_id', '=', 'users.id')
        ->leftjoin('user_aci_indexs','teamingup_group_users.user_id', '=', 'user_aci_indexs.user_id')

         ->select('users.username','user_aci_indexs.aci_index')->whereIn('teamingup_group_users.teaming_group_id', explode(',', $value))->Where('users.status', 1)->groupBy('teamingup_group_users.user_id')
        ->get();


        // $creator = User::where('id', $group_detail->created_by)
        // ->first();

        $groupworkout =DB::table('teamingup_workout')
        ->leftjoin('workout_library','teamingup_workout.workout_id', '=', 'workout_library.id')

         ->select('workout_library.title')->whereIn('teamingup_workout.teaming_group_id', explode(',', $value))
        ->get();

        // // print_r(DB::getQueryLog());die;
        // echo "<pre>";print_r($groupmember);
        // return redirect('')
        // return response()->json([
        //     'success' => true,
        //     'data'=> $members
        // ], 200);

        $view = view("frontend.athlete.compare.group-compare")
         ->with('group_detail',$group_detail)
        ->with('groupmember',$groupmember)
        ->with('groupworkout',$groupworkout)
        ->render();

    return response()->json(['html'=>$view]);

    }

    public function createComparison(Request $request)
    {
        // dd($request->all());
        $allSelectedLibrary = $request->input('allSelectedLibrary');
        
        $request->validate([
            'comparison_name' => 'required',
        ]);
        $data = $request->only(
            'comparison_name'
        );
        $data['created_by']= Auth()->user()->id;
        
        $groupid = CompareGroup::insertGetId($data);

        // $user_id= Auth()->user()->id;
        // $creatorDetail = User::where('id', $user_id)       
        // ->first();         
        if($groupid){            
            $group_user_id = $request->input('compare_grp');
            // $workout_id = $request->input('workout_id');           
            // for($i=0; $i<count($workout_id); $i++){
            // $workoutData= array(
            //     'teaming_group_id' => $groupid, 
            //     'workout_id' => $workout_id[$i],          
            // );

            // TeamingWorkout::insert($workoutData);
        }
        if($group_user_id!=""){

            for($i=0; $i<count($group_user_id); $i++){
            $groupData= array(
                'comparison_group_id' => $groupid, 
                'user_id' => Auth()->user()->id, 
                'compare_user_id' => $group_user_id[$i],                        
            );

            Compare::insert($groupData);

            }

            $CompareHeader= array(
                'compare_group_id' => $groupid, 
                'user_id' => Auth()->user()->id, 
                'selected_column' => $allSelectedLibrary,
                'name'  =>  $request->input('comparison_name'),
                'is_group' => 0

            );
            MemberCompareHeader::insert($CompareHeader);
        }
         return response()->json([
                    'success' => true,
                    'message' => 'Comparison added'
                ], 200);
    }

    public function updateComparison(Request $request,$id)
    {
        $comparisonId=$id;      
        $group_user_id = $request->input('compare_grp');
        if($group_user_id!=""){

            for($i=0; $i<count($group_user_id); $i++){
            $groupData= array(
                'comparison_group_id' => $comparisonId, 
                'user_id' => Auth()->user()->id, 
                'compare_user_id' => $group_user_id[$i],                        
            );

            Compare::insert($groupData);

            }
        }
         return response()->json([
                    'success' => true,
                    'message' => 'Comparison added'
                ], 200);
    }

    public function comparisonDetails($id='',$wrk_id='')
    {
        $wrk_fill = '';
        if($wrk_id != ''){
        $wrk_fill = $wrk_id;
        }
        // echo "<pre>";
        $MemberCompareHeader = MemberCompareHeader::where('compare_group_id', $id)->first(); // only aci  
        $allHeaderCompare = $MemberCompareHeader['selected_column'];
        $allHeaderComparefin = (rtrim($allHeaderCompare,','));
        $allHeaderCompare_array = (explode(",",$allHeaderComparefin));

        // print_r($allHeaderCompare_array);
        $workout_librarys = array();
        $arr = array();
        $temp = [];
        foreach($allHeaderCompare_array as $value){
            $workCatLib = WorkoutCategoryLibrary::where('id', $value)->first();

            $temp['Workout_category_library_id'] = $workCatLib->id;
            $temp['workout_category_id'] = $workCatLib->workout_category_id;
            $temp['workout_library_id'] = $workCatLib->workout_library_id;
<<<<<<< .mine
||||||| .r6683
            $temp['workout_library_title'] = $workoutLibraryName->title;
            
=======
            $temp['title'] = $workoutLibraryName->title;
            
>>>>>>> .r6706
            $workout_librarys [] = $temp;
            $arr[] = $workCatLib->id;

        }
        // print_r($workout_librarys);
        // print_r($arr);
        // die;
        
        $CompareGroup = CompareGroup::find($id);
       
        // $workout_library = UserWorkoutLibrary::where('user_id', Auth()->user()->id)->where('status', 1)->where('workout_id', 8)->get(); // only aci  
        // print_r($workout_library);
        // $workout_librarys = [];
        // if(count($workout_library) > 0){
        //     $arr = array();
        //     foreach($workout_library as $key => $val){
        //         $temp = WorkoutLibrary::where('status', 1)->where('id', $val->workout_library_id)->first();
        //         if($temp){
        //             $cat = WorkoutCategory::where('status', 1)->where('id', $val->workout_id)->first();
        //             $temp['category_title'] =  $cat->category_title;
        //             $temp['category_id'] =  $cat->id;
        //              $temp['workout_id'] = $val->workout_library_id;
        //             $workout_librarys[] = $temp;
        //             $arr[] =  $val->workout_library_id;


        //         }
        //     }
        // }
        // print_r($workout_librarys);
        // print_r($arr);
        // die;
        //compare list
       
         //    new api  start

        $user_id = Auth()->user()->id;
        $comparisonId = $id;
        //  all compare group user id
        $compare_with = Compare::where('user_id', $user_id)->where('status', 1)->where('comparison_group_id', $comparisonId)->get();
        // print_r($compare_with); die;
        $compare_withs = [];

        $temp_self = User::where('role_id', 1)->where('id', $user_id)
        ->first();
        $user_aci = UserAciIndex::where('status', 1)->where('user_id', $user_id)
        ->first();
        $temp_self['aci_index'] =  $user_aci ? $user_aci->aci_index : 0;

        foreach ($compare_with as $key => $value) {
            $temp_user = User::where('id', $value->compare_user_id)
            ->first();

            $user_aci = UserAciIndex::where('status', 1)->where('user_id', $value->compare_user_id)
            ->first();

             $temp_user['compare_id'] =  $value->id;
             $temp_user['aci_index'] =  $user_aci ? $user_aci->aci_index : 0;

            $compare_withs[] = $temp_user;
         }
         $compare_withs[] = $temp_self;
       
        if($wrk_fill == '' ){
            $compare_array = collect($compare_withs)->sortBy('aci_index')->reverse()->toArray();
            }else{
            $compare_array = collect($compare_withs)->sortBy($wrk_fill)->reverse()->toArray();
            }
        // print_r($compare_array); die; // all user value

        if(count($compare_array) > 0){

            $compare_value_user = [];
            $temp_value = [];
            $rank=1;
            $pos=1;
            foreach($compare_array as $key => $compare_list){
                // print_r($compare_list);die;
            $newpos = $pos++;
            $per = ($newpos == 1) ? ((1*1)*99) : ((1-($newpos/count($compare_array)))*100);

                $temp_user = UserWorkoutExercises::where('status', 1)->where('user_id', $compare_list['id'])->whereIn('workout_category_librarys_id', $arr)->get();
                
                // print_r($temp_user);
                $user_aci = UserAciIndex::where('status', 1)->where('user_id', $compare_list['id'])->first();
                $temp_value['aci_index'] =  $user_aci ? $user_aci->aci_index : 0;
                $temp_value['profile_image'] =  isset($compare_list["profile_image"])? asset($compare_list["profile_image"]) : asset("public/frontend/athlete/images/defaultuser.jpg") ;   
                $temp_value['username'] = $compare_list["username"];
                $temp_value['id'] = $compare_list["id"];

                if(count($temp_user) > 0){
                    $tmpArr =array();
                   
                    foreach($temp_user as $tu){
                        $tmpArr[$tu->workout_category_librarys_id]	= $tu;
                    }
                    
                   
                    if(!empty($arr)){
                        foreach($arr as $a){
                            // print_r($a); die;
                            $temp_value[$a] = ((array_key_exists($a, $tmpArr)) ?  $tmpArr[$a]['unit_1'] : '0') ;
                        }
                    }
                    else{
                        foreach($arr as $a){
                          $temp_value[$a] =  0;
                        }
                    }

                }else{
                        foreach($arr as $a){
                          $temp_value[$a] =  0;
                        }
                }
                
                $compare_value_user[] = $temp_value;
        
            }
        }

        // $compare_array = $this->sort_array_of_array($compare_value_user, $wrk_fill);
        // $compare_array12 = collect($compare_value_user)->sortBy($wrk_fill)->reverse()->toArray();
        if($wrk_fill == '' ){
            $compare_array12 = collect($compare_value_user)->sortBy('aci_index')->reverse()->toArray();
            }else{
            $compare_array12 = collect($compare_value_user)->sortBy($wrk_fill)->reverse()->toArray();
        }
        // echo "<pre>";
        // print_r($compare_array12);
        // die;
        // echo "<pre>";
        // print_r($compare_value_user);
        // die;
               //    new api  end


        //  echo "<pre>";
        // print_r($compare_withs); die; 
        return view('frontend.athlete.compare.group-compare')
        ->with('workout_librarys',$workout_librarys)
        ->with('CompareGroup',$CompareGroup)
        ->with('compare_withs',$compare_array12)->with('group_id', $id)->with('wrk_fill', $wrk_fill);
    }

    function sort_array_of_array($array, $subfield)
        {
            // echo "g"; die;
            $sortarray = array();
            foreach ($array as $key => $row)
            {
                $sortarray[$key] = $row[$subfield];
            }

           return array_multisort($sortarray, SORT_ASC, $array);
        }


    public function createComparisonFromGroup(Request $request)
    {
        // dd($request->all());
        // die;
        
        $allSelectedLibrary = $request->input('allSelectedLibrary');
        $request->validate([
            'group_comparison_name' => 'required',
        ]);
        $data['comparison_name'] = $request->group_comparison_name;
        $data['created_by']= Auth()->user()->id;
        $groupid = CompareGroup::insertGetId($data);
        
        if($groupid){            
            $group_user_id = $request->input('group_compare');
        }

        $group_detail = Teaming::whereIn('id',$group_user_id)->get();
        
         $groupmember =DB::table('teamingup_group_users')
        ->leftjoin('users','teamingup_group_users.user_id', '=', 'users.id')

         ->select('users.id')->whereIn('teamingup_group_users.teaming_group_id',$group_user_id)->Where('users.status', 1)->Where('users.role_id', 1)->Where('users.id','!=', Auth()->user()->id)->groupBy('teamingup_group_users.user_id')
        ->get();
        if($groupmember!=""){

            for($i=0; $i<count($groupmember); $i++){
            $groupData= array(
                'comparison_group_id' => $groupid, 
                'user_id' => Auth()->user()->id, 
                'compare_user_id' => $groupmember[$i]->id,                        
            );
            Compare::insert($groupData);

            }

            $CompareHeader= array(
                'compare_group_id' => $groupid, 
                'user_id' => Auth()->user()->id, 
                'selected_column' => $allSelectedLibrary,
                'name'  =>  $request->input('group_comparison_name'),
                'is_group' => 1

            );
            MemberCompareHeader::insert($CompareHeader);
        }
         return response()->json([
                    'success' => true,
                    'message' => 'Comparison added'
                ], 200);
    }


}



