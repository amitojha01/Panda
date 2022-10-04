<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\College;
use App\Models\Travel;
use App\Models\CollegiateConfernce;

class CollegeController extends Controller
{
    /*
        @type[1->college, 2->school, 3->club] 
    */
    public function index(Request $request){
        try{
            $page = 1;
            $limit = 2000;
            $offset = 0;
            if($request->input('page')){
                $page = $request->input('page');
                if(!empty($request->input('limit'))){
                    $limit = $request->input('limit');
                }
                $offset = ($page - 1) * $limit;
                $limit = $limit;
            }

            $division = $request->input('division_id');
            $state = $request->input('state_id');
            $conference = $request->input('conference_id');
            $title = $request->input('title');

            $sql = College::where(['status'=> 1, 'type'=> 1]);
            if(!empty($title)){
                $sql->where('name','LIKE','%'.$title.'%');
            }
            
            if(!empty($state)){
                $sql->whereIn('state_id', explode(",", $state));
            }
            if(!empty($division)){
                $colleges_id = CollegiateConfernce::whereIn('division_id', explode(",", $division))->get()->pluck('college_id');
                $sql->whereIn('id', $colleges_id);
            }
            if(!empty($conference)){
                $colleges_id = CollegiateConfernce::whereIn('collegiate_confernce_id', explode(",", $conference))->get()->pluck('college_id');
                $sql->whereIn('id', $colleges_id);
            }
            $data =  $sql->offset($offset)->limit($limit)->get();
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
    public function getSchool(){
        try{
            $data = College::where(['status'=> 1, 'type'=> 2])->get();
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
    /**
     * @return club,travel,Rec
    */
    public function getClubs(){
        try{
            $data = Travel::where(['status'=> 1])->get();
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
