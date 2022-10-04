<?php

namespace App\Http\Controllers\Auth;

// Required if your environment does not handle autoloading
//require_once('../../../../vendor/twilio/sdk/src/Twilio/autoload.php');

// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;

// use Twilio\Rest\Client;
// require_once "Twilio\autoload.php";
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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


    

    protected function sendSmszz(Request $request){

        $mobile= $request->mobile;
        $phone ="7205144047";
        $message ="Test message";
        //$baseUrl= URL::to('/');
        //echo $baseUrl;exit;
       // echo url('/');
       // include( url('/').'vendor/Twilio/Rest/Client.php');
      
       // $twilio         = new Client(Config::get('constants.twilio_sid'), Config::get('constants.twilio_auth_token'));

        $twilio         = new Client('ACbcb08ba27f137d3990c1745817e7c01e','28a93ffd00d39d97129b32e45c6123ff');
        $twilio->messages->create(
            $phone,
            array(
                'from' => Config::get('constants.twilio_phone'),
                'body' => $message
            )
        );
    }

    protected function sendSms(Request $request){


        $id = "AC0158744901aa8c071659e39bf0dbe374";
        $token = "24ccbb5f4c209c671a5e730ed2229993";
        $url = "https://api.twilio.com/2010-04-01/Accounts/$id/SMS/Messages";
        $from = "16165778663";
$to = "917205144047"; // twilio trial verified number
$body = "test  message";
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




}
