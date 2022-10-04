<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CollegeConferences;

class CollegiateConferncesController extends Controller
{
    public function index(Request $request){
        try{
            $data = CollegeConferences::where(['status'=> 1, 'parent_id'=> 0])->get();
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
     * @request Competitive level which is parent for conferences
    */
    public function getConferences(Request $request){
        try{
            $id = $request->input('id');
            if(!empty($id)){
                $data = CollegeConferences::where(['status'=> 1, 'parent_id'=> $id])->get();
            }else{
                $data = CollegeConferences::where('status', 1)->where('parent_id', '!=', 0)->get();
            }
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
