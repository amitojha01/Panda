<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Subscription;

class SubscriptionController extends Controller
{
    /*
        @request get type
        type[1=>single, 2=>group]
    */
    public function index(Request $request){
        $id = $request->input('type');
        try{
            if($id != ''){
                $data = Subscription::where('type', $id)->get();
            }else{
                $data = Subscription::all();
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
