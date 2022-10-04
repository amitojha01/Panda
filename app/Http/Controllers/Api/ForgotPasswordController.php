<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPasswordOtp;

use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function getForgotPasswordOtp(Request $request)
    {
        $data = $request->only('email');
        $validator = Validator::make($data, [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->messages()
            ], 422);
        }
        $otp = mt_rand(1111, 9999);
        try{
            $user = User::where($data)->where('status', '!=', 9)->first();
            if(empty($user)){
                return response()->json([
                    'success' => false,
                    'message'=> "Sorry!! Email no found"
                ]);
            }
            $data['otp'] = $otp;
            $data['email'] = $user->email;
            Mail::to($data['email'])->send(new ForgotPasswordOtp($data));
            //update email to the 
            $user->remember_token = $otp;
            $user->save();
            return response()->json([
                'success' => true,
                'message'=> "Please check your email to get your Forgot Password OTP",
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message'=> $e->getMessage()
            ], 200);
        }
    }
    /**
     * @resuest email, otp
     * @response
    */
    public function validatePasswordOtp(Request $request)
    {
        $data = $request->only('email', 'otp');
        $validator = Validator::make($data, [
            'email' => 'required|email',
            'otp' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->messages()
            ], 422);
        }
        $where = array(
            'email'=> $request->input('email'),
            'remember_token'=> $request->input('otp'),
        );
        try{
            $user = User::where($where)->where('status', '!=', 9)->first();
            if(empty($user)){
                return response()->json([
                    'success' => false,
                    'message'=> "Sorry!! OTP not matched"
                ]);
            }
            return response()->json([
                'success' => true,
                'message'=> "OTP matched ",
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message'=> $e->getMessage()
            ], 200);
        }
    }
    /*
        ** Update password
    */
    public function postUpdatePassword(Request $request)
    {

        $data = $request->only('email');
        $validator = Validator::make($data, [
            'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->messages()
            ], 422);
        }
        $where = array(
            'email'=> $request->input('email')
        );
        try{
            $user = User::where($where)->where('status', '!=', 9)->first();
           
            if(empty($user)){
                return response()->json([
                    'success' => false,
                    'message'=> "Sorry!! Something went wrong"
                ]);
            }
            $user->password = Hash::make($request->input('password'));
            $user->remember_token = null;
            $user->save();
            return response()->json([
                'success' => true,
                'message'=> "Password changed successfully",
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message'=> $e->getMessage()
            ], 200);
        }
    }
}
