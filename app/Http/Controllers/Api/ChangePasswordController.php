<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\User;

class ChangePasswordController extends Controller
{
    public function updatePassword(Request $request){   
        $user = User::find(auth('api')->user()->id);

        $data = $request->only('password', 'confirm_password');
        $validator = Validator::make($data, [
            'password'=> 'required|min:8',
            'confirm_password'=> 'required|min:8'
        ]);
        if ($validator->fails()) {
            $err= $validator->errors();
            $err_msg = '';
            foreach(json_decode($err) as $key=> $val){
                $err_msg = $val[0];
                break;
            }
            return response()->json([
                'success' => false,
                'error' => $err_msg
            ], 422);
        }

        try{
            
            $user->password = Hash::make($data['confirm_password']);        
            $user->save();

            return response()->json([
                'success'=> true,
                'message'=> 'Password update successfully'
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                'success'=> false,
                'message'=> 'Unable to process the request'
            ], 500);
        }
    }
}
