<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SportPosition;

class SportsPositionController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('sport_id');
        try{
            $data = SportPosition::where('status', 1)->where('sport_id', $id)->get();
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
