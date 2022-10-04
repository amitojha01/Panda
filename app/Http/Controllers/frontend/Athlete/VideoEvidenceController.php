<?php

namespace App\Http\Controllers\Frontend\Athlete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VideoEvidence;
use App\Models\VideoEvidenceLike;
use App\Models\WorkoutCategory;
use App\Models\WorkoutLibrary;
use App\Models\State;
use Session;
use DB;
use Illuminate\Support\Facades\Hash;
class VideoEvidenceController extends Controller
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

     $athlete = User::where('role_id', 1)
     ->with('address')
     ->get(); 
     $data = VideoEvidence::select('video_evidence.*','wc.category_title','wl.title')
     ->join('workout_category as wc', 'wc.id' , 'video_evidence.workout_category_id')
     ->join('workout_library as wl', 'wl.id', 'video_evidence.workout_type_id')
     ->where('video_evidence.status','!=', 3)
     ->get(); 
     $i=0;
     foreach ($data as $key => $value) {
        $likeVideoEvidence = VideoEvidenceLike::where('status', 1)->where('video_evidence_id', $value['id'])->get()->count() ;
        $data[$i]['like_count'] = $likeVideoEvidence;
        $i++;
    }
    
    return view('frontend.athlete.video.list')
    ->with('video_evidence_list', $data)
    ->with('likeVideoEvidence', $likeVideoEvidence);
}
public function saveVideoEvidence(Request $request){
    $request->validate([
        'date_of_video' => 'required',
        'workout_category_id' => 'required|int',
        'workout_type_id' => 'required|int',
        'video_link' => 'required',
    ]);
    try{
        
        $user_id= Auth()->user()->id;
        $data = $request->only('date_of_video', 'workout_category_id', 'workout_type_id', 'video_link', 'video_embeded_link');
        
        $data['user_id'] = $user_id;
        if (empty($request->videoEvidenceId)) {
            if(VideoEvidence::insert($data)){            
                return redirect('/athlete/video-evidence')->with('success','Add Video Evidence Successfully');
            }else{
                return back()->with('error', 'Failed to add event');
            }
        }else{
            if(VideoEvidence::where('id', $request->videoEvidenceId)->update($data)){            
                return redirect('/athlete/video-evidence')->with('success','Video Evidence Updated Successfully');
            }else{
                return back()->with('error', 'Failed to update event');
            }
        }

    }
    catch(\Exception $e)
    {
        dd($e);
        return back()->with('error','Unable to save data');
    }
}
public function addVideoEvidence($id="")
{      
 $user_id= Auth()->user()->id;

 $athlete = User::where('role_id', 1)
 ->with('address')
 ->get(); 
 if (!empty($id)) {
     $data = VideoEvidence::where('id', $id)  
     ->first();
     
     return view('frontend.athlete.video.add-edit')
     ->with('data', $data);
 }else{
    return view('frontend.athlete.video.add-edit');
}


}
public function deleteVideoEvidence($id="")
{      
 $user_id= Auth()->user()->id;
 $eventId=$id;
 if(VideoEvidence::where('id', $eventId)->update(['status'=>3])){            
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
public function likeVideoEvidence(Request $request){
    
    $user_id= Auth()->user()->id;
    $video_evidence_id = $request->video_evidence_id;
    $data = $request->only('video_evidence_id');
    $data['user_id'] = $user_id;
    
    $exit_like_user = $athlete = VideoEvidenceLike::where('status', 1)->where('user_id', $user_id)->where('video_evidence_id', $video_evidence_id)->first();
    if (empty($exit_like_user)) {
        if(VideoEvidenceLike::insert($data)){  
            $response['videocount'] = VideoEvidenceLike::where('status', 1)->where('video_evidence_id', $video_evidence_id)->get()->count() ;
            $likeVideoEvidence;
            
            return response()->json([
                'success' => true,
                'data'=> $response
            ], 200);
        }
    }else{
       $id=$exit_like_user->id;
       if(VideoEvidenceLike::find($id)->delete()){
        $response['videocount'] = VideoEvidenceLike::where('status', 1)->where('video_evidence_id', $video_evidence_id)->get()->count() ;
        $likeVideoEvidence;
    }
    return response()->json([
        'success' => true,
        'data'=> $response
    ], 200);
}        
}


public function workoutDetail(Request $request)
{
    $category_id= $request->workout_category;
    $workout_type_id = $request->workout_type;
    $cat_detail=  WorkoutCategory::where('id', $category_id)->first();
    $type_detail=  WorkoutLibrary::where('id', $workout_type_id)->first();
    $data= array('cat_detail'=> $cat_detail, 'type_detail'=>$type_detail);
    
    return response()->json($data);
}
}