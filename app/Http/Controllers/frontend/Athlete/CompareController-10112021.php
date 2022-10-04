<?php

namespace App\Http\Controllers\Frontend\Athlete;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Compare;
use App\Models\UserWorkoutLibrary;
use App\Models\WorkoutLibrary;
use App\Models\WorkoutCategory;
use App\Models\UserWorkoutExerciseLog;
use App\Models\UserAciIndex;
use App\Models\TeamingGroupUser;
use App\Models\Teaming;
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
    public function index()
    {   
        //workout list
         $workout_library = UserWorkoutLibrary::where('user_id', Auth()->user()->id)->where('status', 1)->where('workout_id', 8)->get();
        $workout_librarys = [];
        if(count($workout_library) > 0){
            foreach($workout_library as $key => $val){
                $temp = WorkoutLibrary::where('status', 1)->where('id', $val->workout_library_id)->first();
                if($temp){
                    $cat = WorkoutCategory::where('status', 1)->where('id', $val->workout_id)->first();
                    $temp['category_title'] =  $cat->category_title;
                    $temp['category_id'] =  $cat->id;
                     $temp['workout_id'] = $val->workout_library_id;
                    $workout_librarys[] = $temp;


                }
            }
        }
        //compare list
        $compare_with = Compare::where('status', 1)->where('user_id', Auth()->user()->id)->get();
        $compare_withs = [];
        $temp_self = User::where('role_id', 1)->where('id', Auth()->user()->id)
        ->first();
        $user_aci = UserAciIndex::where('status', 1)->where('user_id', Auth()->user()->id)
        ->first();
        $temp_self['aci_index'] =  $user_aci ? $user_aci->aci_index : 0;
        foreach ($compare_with as $key => $value) {
            $temp_user = User::where('role_id', 1)->where('id', $value->compare_user_id)
            ->first();

            $user_aci = UserAciIndex::where('status', 1)->where('user_id', $value->compare_user_id)
            ->first();

             $temp_user['compare_id'] =  $value->id;
             $temp_user['aci_index'] =  $user_aci ? $user_aci->aci_index : 0;

            $compare_withs[] = $temp_user;
         }
         $compare_withs[] = $temp_self;

         //group list
        $user_id= Auth()->user()->id;
        $group =DB::table('teamingup_group')
        ->leftjoin('teamingup_group_users','teamingup_group.id', '=', 'teamingup_group_users.teaming_group_id')

         ->select('teamingup_group.id','teamingup_group.group_name','teamingup_group.description','teamingup_group.image','teamingup_group.created_by','teamingup_group_users.user_id','teamingup_group_users.is_joined')->where('teamingup_group.created_by', $user_id)->orWhere('teamingup_group_users.user_id', $user_id)->groupBy('teamingup_group.id')
        ->get();
       
       // dd($group);
        return view('frontend.athlete.compare.index')
        ->with('workout_librarys',$workout_librarys)
        ->with('compare_withs',$compare_withs)
        ->with('group',$group);
    }

     public function AddAthlete()
    {   
        $athlete = User::where('role_id', 1)
        ->with('address')
        ->get();                                         
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
       if(Compare::find($id)->delete()){            
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


}



