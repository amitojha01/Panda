<?php

namespace App\Http\Controllers\Frontend\Athlete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Events;
use App\Models\State;
use App\Models\Sport;
use App\Models\City;

use Session;
use DB;
use Illuminate\Support\Facades\Hash;
class FileUpload extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
       echo phpinfo();
       die;

    }

    public function index(){
        return view('frontend.athlete.fileUpload');
    }

    public function submit_details(Request $request)
    { 
        // echo 'hello'; die;
        if (isset($_POST["sbmt"])) {
            $medicine_name = array();
            $purchase_amount = array();
            // $distributer_id = $this->input->post('distributer_id', TRUE);
            $file = $_FILES['distributer_medicine']['tmp_name'];
            $handle = fopen($file, "r");
            // print_r(fgetcsv($handle));die;
            $c = 0;
            while (($filesop = fgetcsv($handle, 2650, ",")) !== false) {
                $medicine_name = $filesop[0];
                $purchase_amount = $filesop[1]; 

                if (isset($filesop[1])) {
                    $medicine_name = $filesop[0];
                    $purchase_amount = $filesop[1];
                    if ($c <> 0) {  
                        $itmAray['user_type'] = 'm';
                        $itmAray['aci_component'] = "'L Cone Drill";
                        $itmAray['key'] = $filesop[0];
                        $itmAray['value'] = $filesop[1] ? $filesop[1] : 0;
                        $itmAray['status'] = 1;
                        $itmAray['created_at'] = date("d-m-Y H:i", time());
                        $itmAray['updated_at'] = date("d-m-Y H:i", time());

                        // echo "<pre>";
                        // print_r($itmAray);
                        // die;
                       
                        // $this->db->insert('aci_calculation_datas_test', $itmAray);
                        DB::table('aci_calculation_datas')->insert($itmAray);
                        
                    }
                }
                $c = $c + 1;
            }
        }
    }

}