<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\State;
class StateController extends Controller
{
    //
    public function index(Request $request){
        $id = $request->input('country_id');
        try{
            if($id != ''){
                $data = State::where('country_id', $id)->get();
            }else{
                $data = State::all();
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
