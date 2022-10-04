<?php
use Illuminate\Support\Facades\Storage;
use App\Models\Setting;
use App\Models\VideoEvidenceLike;

function pr($data, $action = TRUE){
    print "<pre>";
    print_r($data);
    if($action):
        die;
    endif;
}
function formatDateTime($object, $format = 'jS F, Y'){
    return date_format(date_create($object), $format);
}
function returnJson($returnData = array(), $mode = TRUE){
    print json_encode($returnData);
    if ($mode) :
        die;
    endif;
}
function extractJson($string){
    $valid = is_string($string) && (is_object(json_decode($string)) || is_array(json_decode($string))) ? true : false;
    if (!$valid) :
        responseToJson(FALSE, "Not JSON");
    else:
        return json_decode($string, TRUE);
    endif;
}
function checkApiKey($postData){
    if (!array_key_exists("key", $postData)) :
        responseToJson(FALSE, "Api key missing");
    elseif ($postData['key'] == "") :
        responseToJson(FALSE, "Key field empty");
    elseif ($postData['key'] != Config::get('constants.api_key')) :
        responseToJson(FALSE, "Wrong Api Key");
    endif;
}
function validateArray($keys, $arr){
    return !array_diff_key(array_flip($keys), $arr);
}
function responseToJson($success = TRUE, $message = "success", $data = NULL, $extraField = array()){
    $response = ["success" => $success, "message" => $message, "data" => $data];
    if (!empty($extraField)) :
        foreach ($extraField as $k => $v) :
            $response[$k] = $v;
        endforeach;
    endif;
    returnJson($response);
}
function uptoTwoDecimal($number){
    return number_format((float)$number, 2, '.', '');
}
function uptoOneDecimal($number){
    return number_format((float)$number, 1, '.', '');
}
function getIpAddress(){
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) :
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) :
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else :
        $ip = $_SERVER['REMOTE_ADDR'];
    endif;
    return $ip;
}
function ipInfo($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) :
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) :
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        endif;
    endif;
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) :
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) :
            switch ($purpose) :
                case "location":
                    $output = array(
                        "city"           => @$ipdat->geoplugin_city,
                        "state"          => @$ipdat->geoplugin_regionName,
                        "country"        => @$ipdat->geoplugin_countryName,
                        "country_code"   => @$ipdat->geoplugin_countryCode,
                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            endswitch;
        endif;
    endif;
    return $output;
}
function UniqueMachineID($salt = "") {
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $temp = sys_get_temp_dir().DIRECTORY_SEPARATOR."diskpartscript.txt";
        if(!file_exists($temp) && !is_file($temp)) file_put_contents($temp, "select disk 0\ndetail disk");
        $output = shell_exec("diskpart /s ".$temp);
        $lines = explode("\n",$output);
        $result = array_filter($lines,function($line) {
            return stripos($line,"ID:")!==false;
        });
        if(count($result)>0) {
            $result = array_shift(array_values($result));
            $result = explode(":",$result);
            $result = trim(end($result));       
        } else $result = $output;       
    } else {
        $result = shell_exec("blkid -o value -s UUID");  
        if(stripos($result,"blkid")!==false) {
            $result = $_SERVER['HTTP_HOST'];
        }
    }   
    return md5($salt.md5($result));
}
function jd($data){
    return json_decode($data, TRUE);
}
function otp($length = '4'){
    //return substr(str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ0123456789'), 0, $length);
    return substr(str_shuffle('0123456789'), 0, $length);
}
function getSettings($settings_type=""){
    if(!empty($settings_type)){
        $setting = Setting::where('key',$settings_type)->first();
        return (!empty($setting['value'])) ? $setting['value'] : false;
    }
    else
    {
        return false;
    }
}

function likeMarkCheck($userId="",$videoid="" ){
    if(!empty($userId)&&!empty($videoid)){
        $exits_like_video = VideoEvidenceLike::where('user_id',$userId)->where('video_evidence_id',$videoid)->first();
        if (empty($exits_like_video)) {
           return true;
        }else
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}

function bubbleSort(&$arr)
{
    $n = sizeof($arr);
 
    // Traverse through all array elements
    for($i = 0; $i < $n; $i++)
    {
        // Last i elements are already in place
        for ($j = 0; $j < $n - $i - 1; $j++)
        {
            // traverse the array from 0 to n-i-1
            // Swap if the element found is greater
            // than the next element
            if ($arr[$j] > $arr[$j+1])
            {
                $t = $arr[$j];
                $arr[$j] = $arr[$j+1];
                $arr[$j+1] = $t;
            }
        }
    }
}

?>