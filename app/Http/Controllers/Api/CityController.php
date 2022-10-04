<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\City;
class CityController extends Controller
{
    //
    public function index(Request $request){        
        $id = $request->input('state_id');

        if($id != ''){
            $data = City::where('state_id', $id)->orderBy('name', 'ASC')->get();
        }else{
            $data = City::all();
        }
        
        return response()->json([
            'success' => true,
            'data'=> $data
        ], 200);
    }

    /**
     * @request city_id:int
     * @response object[]
    */
    public function getZipcodes(Request $request){        
        $id = $request->input('city_id');
        $data = [];
        if($id != ''){
            $data = City::where('id', $id)->get();
        }
        return response()->json([
            'success' => true,
            'data'=> $data
        ], 200);
    }


}
