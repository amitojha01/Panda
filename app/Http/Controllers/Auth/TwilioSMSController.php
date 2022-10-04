<?php

namespace App\Http\Controllers\Auth;

//use Twilio\Rest\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use DB;


class TwilioSMSController extends Controller
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


    protected function sendSms(Request $request){
        $mobile_no= $request->input('mobile');
        $id = "AC0158744901aa8c071659e39bf0dbe374";
        $token = "24ccbb5f4c209c671a5e730ed2229993";
        $url = "https://api.twilio.com/2010-04-01/Accounts/$id/SMS/Messages";
        $from = "16165778663";
        $to = $mobile_no; // twilio trial verified number
        $verification_code=  rand(1000,9999);

        session(['verification_code' => $verification_code, 'mobile_no' => $mobile_no]);
        $body = "Panda Verification code ".$verification_code;
        $data = array (
            'From' => $from,
            'To' => $to,
            'Body' => $body,
        );
        $post = http_build_query($data);
        $x = curl_init($url );
        curl_setopt($x, CURLOPT_POST, true);
        curl_setopt($x, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($x, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($x, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($x, CURLOPT_USERPWD, "$id:$token");
        curl_setopt($x, CURLOPT_POSTFIELDS, $post);
        $y = curl_exec($x);
        curl_close($x);
        var_dump($post);
        var_dump($y);
    }

    public function verifyMobileOtp(Request $request){
          $mobile_otp= $request->input('mobile_otp');
          $mobileNumber= $request->input('mobileNumber');
          $verification_code= Session::get('verification_code');
          $mobile_no= Session::get('mobile_no');
          if($mobile_otp== $verification_code && $mobileNumber == $mobile_no){
            return 1;
          }else{
            return 0;
          }
          
    }

}
