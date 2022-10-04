<?php

namespace App\Http\Controllers\Api\Athlete;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use App\Models\User;
use App\Models\Messagechat;
use App\Models\Follower;
use App\Models\Country;

use Session;
use DB;
use URL;

class ChatController extends Controller
{
    public function index(Request $request)
    { 
        // $user_id = $request->input('user_id'); 
        // echo $user_id; die; 
        $user = auth('api')->user();
            $user_id = $user->id;
        try{
           
            $allChatList = User::where('role_id', 1)->where('id','!=',$user_id)
            // ->select('username')
            ->get();

            $ChatListValue =array();
            $temp = array();
                if(count($allChatList) > 0){
                    foreach($allChatList as $key => $val){

             $user_state =DB::table('user_address')
            ->join('states','states.id', '=', 'user_address.state_id')
            ->select('states.*')
            ->where('user_address.user_id', $val->id )
            ->first();

            $exit_follower_user = Follower::where('status', 1)->where('user_id', $user_id)->where('follower_id',$val->id)->first();
            if($exit_follower_user){
                $follower = true;
            }
            else{
                $follower = false;
            }               

                       $temp['id'] = $val->id;
                        $temp['username'] = $val->username;
                        $temp['email'] = $val->email;
                        $temp['profile_image'] = $val->profile_image;
                        $temp['role_id'] = $val->role_id == 1 ? 'athlete' : 'coach';
                        $temp['state_name'] = !empty($user_state->name) ? $user_state->name  : '' ;
                        $temp['following'] = $follower ;


                        $ChatListValue[] = $temp; 

                    }
                }
                else{
                    $ChatListValue[] = [];
                }

            return response()->json([
                'success' => true,
                'data'=> $ChatListValue
            ], 200);
        }
        catch(\Exception $e){
            return response()->json([
                'success' => true,
                'message' => 'Unable to get request data',
                'data'=> []
            ], 500);
        }
    }

}
?>