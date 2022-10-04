<?php
namespace App\Http\Controllers\Frontend\coach;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\Controller;
// use App\Models\User;
// use App\Models\Events;
// use App\Models\State;
// use Session;
// use DB;
// use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Messagechat;
use Session;
use DB;

// class ChatController extends Controller
// {
//      public function __construct()
//     {
//        // $this->middleware('auth');

//     }

//     // public function index()
//     // {
//     // 	$user_id= Auth()->user()->id;
//     //     return view('frontend.coach.chat.list');
//     // }

//     public function index()
//     {
//     	 $user_id = Auth()->user()->id;

//     	 $chat_details  =   DB::select("SELECT * FROM  connection_message  WHERE (sender_id = '".$user_id."' OR  user_id = '".$user_id."') ORDER by updated_at DESC");
//     	 // print_r($chat_details);die;
//     	 $firebase_chat_id = '';
//     	 $connection_id = '';
//     	 if (count($chat_details) > 0 ) {
//     	 	$i =0 ;
//     	 	 $count = count($chat_details) ;
//     	 	foreach ($chat_details as $key => $value) {
//     	 		// echo $i;
//     	 		if ($i == 0) {
//     	 			$connection_id = $value->connection_message_id;
//     	 		 	$firebase_chat_id = $value->firebase_chat_id;
//     	 		}

//     	 		if ($value->sender_id == $user_id ) {
//     	 		 	$user = User::where('id',$value->user_id)->first();
//     	 		}else{
//     	 			$user = User::where('id',$value->sender_id)->first();
//     	 		}
//     	 		$chat_details[$key]->user =$user ;
//     	 	 $i++ ;
//     	 	}
    	 	
//     	 }
//     	 $det = array('connection_id' => $connection_id , 
//     	 			 'firebase_chat_id' =>	$firebase_chat_id);
//     	 // dd($chat_details);
//     	 // die;
//     	 Session::put('chat',$det);
    		
//         return view('frontend.coach.chat.list')->with('chat_details', $chat_details)->with('det',$det);
//     }
// }

class ChatController extends Controller
{
    public function index()
    {
    	 $user_id = Auth()->user()->id;

    	 $chat_details  =   DB::select("SELECT * FROM  connection_message  WHERE (sender_id = '".$user_id."' OR  user_id = '".$user_id."') ORDER by updated_at DESC");
    	 // print_r($chat_details);die;
    	 $firebase_chat_id = '';
    	 $connection_id = '';
    	 if (count($chat_details) > 0 ) {
    	 	$i =0 ;
    	 	 $count = count($chat_details) ;
    	 	foreach ($chat_details as $key => $value) {
    	 		// echo $i;
    	 		if ($i == 0) {
    	 			$connection_id = $value->connection_message_id;
    	 		 	$firebase_chat_id = $value->firebase_chat_id;
    	 		}

    	 		if ($value->sender_id == $user_id ) {
    	 		 	$user = User::where('id',$value->user_id)->first();
    	 		}else{
    	 			$user = User::where('id',$value->sender_id)->first();
    	 		}
    	 		$chat_details[$key]->user =$user ;
    	 	 $i++ ;
    	 	}
    	 	
    	 }
    	 $det = array('connection_id' => $connection_id , 
    	 			 'firebase_chat_id' =>	$firebase_chat_id);
    	 // dd($chat_details);
    	 // die;
    	 Session::put('chat',$det);
    		
        return view('frontend.coach.chat.list')->with('chat_details', $chat_details)->with('det',$det);
    }
    public function getchat(Request $request)
    {
    	$data['chat_id'] = base64_decode($request['chat_id']);
    	$user_id = Auth()->user()->id;
		// die;
    	$chat_details  =   Messagechat::where('firebase_chat_id',$data['chat_id'])->first();;
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://mypandatest-default-rtdb.firebaseio.com/'.$data['chat_id'].'.json',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json'
		  ),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		$response  =  json_decode($response);
		// echo "<pre>";
		// print_r($response);
		// die;
		$html = '';
		
		$userDet = User::where('id',$chat_details['user_id'])->first();
		// echo "<pre>";
		// print_r($user);
		// die;
		$messagehead['username'] = $userDet['username'];
		$messagehead['image'] = !empty($userDet['profile_image']) ? url($userDet['profile_image']) : url('public/frontend/images/default-user.jpg') ;

		$det = array('connection_id' => $chat_details['connection_message_id'] , 
    	 			 'firebase_chat_id' =>	$data['chat_id']);
        Session::forget('chat');
		Session::put('chat',$det);
        $date =  Session::get('chat')  ;
       
		if (!empty($response)) {
			foreach ($response as $key => $value) {
				if ($value->sender_image =='') {
					$send_image =  url('public/frontend/images/default-user.jpg');
				}else{
					$send_image = $value->sender_image;
				}
				if ($value->receiver_image =='') {
					$receiver_image = url('public/frontend/images/default-user.jpg');
				}else{
					$receiver_image = $value->receiver_image;	
				}
				$chat_html = '';
				if ($value->file =='') {
					$file = '';
				}else{
					$file = $value->file;
					$chat_html = '<h6><span><a href="'.$file.'" target="_blank" style="">Document</a></span></h6>';
				}	

                if (isset($value->message) && !empty($value->message)){
                    $message =  $value->message ;

                    $sms= '<h6><span>'.$message.'</span></h6>';
                }else{
                     $message = '';
                      $sms = '';
                }
				if ($value->sender_id != $user_id ) {
					$html .= '<div class="textchat2">
                        <div class="textchat2_img"><img src="'.$send_image.'" alt="user_img"/></div>'.$sms.'
                        '.$chat_html.'
                      </div><div class="clr"></div>';
				}else{
					$html .= '<div class="textchat1">
                        <div class="textchat1_img"><img src="'.$send_image.'" alt="user_img"/></div>'.$sms.''.$chat_html.'
                      </div>
                      <div class="clr"></div>';
				}
			}
		}else{

		}
		return response()->json([
            'success' => true,
            'data'=>  $html ,
            'data1'=>$det,
			'messagehead' => $messagehead,
            'message'=>'Chat Data found'
        ], 200);
    }


    public function savechat(Request $request)
    {
    	$data =  $request->all();
    	$user_id = Auth()->user()->id;
    	$chat_details  =   Messagechat::where('connection_message_id',$data['connection_id'])->first();;
    	$sender_details = User::where('id',$user_id)->first(); 
    	if ($sender_details['profile_image'] != '' ) {
    		$sender_image = url($sender_details['profile_image']);
    	}else{
    		$sender_image = '';
    	}
    	if ($chat_details['sender_id'] == $user_id) {
    		$receiver_id = $chat_details['user_id'];
    	}else{
    		$receiver_id = $chat_details['sender_id'];
    	}
    	$receiver_details = User::where('id',$receiver_id)->first();
    	if ($receiver_details['profile_image'] != '' ) {
    		$receiver_image = url($receiver_details['profile_image']);
    	}else{
    		$receiver_image = '';
    	} 
    	$file = '';
    	if (request()->hasFile('image')) {
                $file = request()->file('image');
                $fileName = time() . "." . $file->getClientOriginalExtension();
                if($file->move('public/uploads/chat_files/', $fileName)){
                    $file = url('public/uploads/chat_files/'.$fileName);
                }
        }
    	$message =  array(
    			'file' 			=> $file,
    			'message' 		=> $data['message'] ,
    			'sender_id' 	=> $user_id ,
    			'sender_name'	=>$sender_details['username'] ,
    			'sender_image'	=>$sender_image ,
    			'receiver_id'	=> $receiver_id,
    			'receiver_name'	=>$receiver_details['username'], 
    			'receiver_image'=>$receiver_image,
    			'created_at'    =>date('Y-m-d H:I:m') 
    			);
    	if ($chat_details['firebase_chat_id'] == '') {
    		$firebase_chat_id =  $user_id.'-'.$receiver_id;
    		Messagechat::where('connection_message_id', $chat_details['connection_message_id'])->update(['firebase_chat_id'=>$firebase_chat_id ,'updated_at' =>date('Y-m-d H:i:m')]);
    	}else{	
    		$firebase_chat_id = $chat_details['firebase_chat_id'] ;
    		Messagechat::where('connection_message_id', $chat_details['connection_message_id'])->update(['updated_at' =>date('Y-m-d H:i:m')]);
    	}
    	 $this->firebaseChatAdd($message, $firebase_chat_id);


        $chat_details  =   Messagechat::where('connection_message_id',$data['connection_id'])->first();;
        $chat_details->firebase_chat_id = base64_encode( $chat_details->firebase_chat_id);
        return response()->json([
            'success' => true,
            'data'=>  $chat_details ,
            'message'=>'Chat Data found'
        ], 200);

    }

    public function firebaseChatAdd($message,$firebase_chat_id)
    {
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://mypandatest-default-rtdb.firebaseio.com/'.$firebase_chat_id.'.json',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>json_encode($message),
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		// echo $response;
    }

    public function SearchConnection (Request $request)
    {
       $data =  $request->all();
       // echo "<pre>";
       // print_r($data);
        $user_id = Auth()->user()->id;
        $chat_details  =   DB::select("SELECT c_m.* FROM  connection_message As c_m LEFT JOIN users As a ON c_m.sender_id= a.id  LEFT JOIN users As b ON c_m.user_id= b.id    WHERE (c_m.sender_id = '".$user_id."' OR  c_m.user_id = '".$user_id."') AND (a.username LIKE  '%".$data['search']."%' OR b.username LIKE  '%".$data['search']."%') ORDER by c_m.updated_at DESC");
         $firebase_chat_id = '';
         $connection_id = '';
         if (count($chat_details) > 0 ) {
            $i =0 ;
             $count = count($chat_details) ;
            foreach ($chat_details as $key => $value) {
                // echo $i;
                if ($i == 0) {
                    $connection_id = $value->connection_message_id;
                    $firebase_chat_id = $value->firebase_chat_id;
                }

                if ($value->sender_id == $user_id ) {
                    $user = User::where('id',$value->user_id)->first();
                    $user->profile_image = url($user->profile_image);
                }else{
                    $user = User::where('id',$value->sender_id)->first();

                    $user->profile_image = url($user->profile_image);
                }
                $chat_details[$key]->user =$user ;
             $i++ ;
            }
            
         }
         $det = array('connection_id' => $connection_id , 
                     'firebase_chat_id' =>  $firebase_chat_id);
         Session::put('chat',$det);
         // dd($chat_details);
         $html = '';
            if(count($chat_details)){
                $i= 0 ;
                $html = '';
                foreach($chat_details As $chatlist){
                    $val = base64_encode($chatlist->firebase_chat_id);
                    if($i == 0 ){
                        $status = "active";
                    }else{
                        $status = '';
                    } 
                    $image_html = '';
                    // print_r($chatlist->user);
                    if($chatlist->user->profile_image !=''){ 
                        $image_html = '<img src="'.url('public/frontend/images/default-user.jpg').'" alt="chaiprofileimg"/> <!-- <i></i>  -->' ;
                    }else{
                        $image_html = '<img src="'.url('public/frontend/images/default-user.jpg').'" alt="chaiprofileimg"/> <!-- <i></i>  -->';
                    } 

                    if($chatlist->user->role_id == 1){
                       $type = ' <span> Athlete</span> ';
                    }else{
                       $type = '<span>Coach </span> ';
                    }
                          
                        
                    $html .= '<div class="chatlistbox GeChatList '.$status.'  " data-chat_id ="'.$val.'" data-conection_id ="'. $chatlist->connection_message_id.'"  >
                        <div class="chatlistbox_l">
                        '.$image_html.'
                        </div>
                        <div class="chatlistbox_mid">
                            <h6>'.$chatlist->user->username.'</h6>
                            '.$type.'       
                        </div>
                        <!--   <div class="chatlistbox_r"> <span>2</span> </div> -->
                          <div class="clr"></div>
                        </div>';
                    $i++;
                }
            }
          return response()->json([
            'success' => true,
            'data'=>  $chat_details ,
            'html'=>  $html ,
            'message'=>'Chat Data found'
        ], 200);
    }

	public function messagePage()
	{
		$user_id = Auth()->user()->id;

		$all_caht_user = DB::table('message_chat')->where('sender_id', '=', $user_id)->orWhere('receiver_id', '=', $user_id)->get();
		// echo "<pre>";
		// print_r($all_caht_user);
		// die;
		return view('frontend.coach.chat.chat_List');
	}

	public function allChatIds()
	{
		$user_id = Auth()->user()->id;
		$all_caht_id = DB::table('users_chats_id')->where('user_id', '=', $user_id)->first();
		// echo "<pre>";
		$all_chat_ids = $all_caht_id->chat_ids;
		$chat_ids_array =  explode(",", $all_chat_ids);
	
		$all_user = User::whereIn('id', $chat_ids_array)->get();

		$all_user_array = [];
		$temp = [];
		foreach($all_user as $user_final){
			$all_read_message = DB::table('message_chat')->where('receiver_id', '=', $user_id)->where('sender_id', '=', $user_final['id'])->where('status', '=', 'U')->get();

			$temp['user_id'] = $user_final['id'] ? $user_final['id'] : '';
			$temp['name'] = $user_final['username'] ? $user_final['username'] : '';
			$temp['type'] = $user_final['role_id'] == 1 ? 'athlete' : 'Coach';
			$temp['all_read_message'] = count($all_read_message) ? count($all_read_message) : 0;
			$temp['user_image'] = $user_final['profile_image'] ? url($user_final['profile_image']) : url('public/frontend/images/default-user.jpg') ;
			
			$all_user_array[] =$temp;
		}
		// echo "<pre>";
		// print_r($all_user_array);
		// die;

		if(!empty($all_user_array)){
			return response()->json([
				'success' => true,
				'data'=>  $all_user_array ,
				// 'html'=>  $html ,
				'message'=>'Chat Data found'
			], 200);
		}
		else{
			return response()->json([
				'success' => false,
				// 'data'=>  $all_user_array ,
				// 'html'=>  $html ,
				'message'=>'No data found'
			], 200);
		}
	
	}

	public function viewChats(Request $request)
	{
	   $data =  $request->input();
        //    echo "<pre>";
    	//  print_r($data);
	   $user_id = Auth()->user()->id;
	   $chatid = $data['chatid'];

	   $select_chat_user = User::where('id',$chatid)->first();
	   $header_chat_details['profile_image'] = $select_chat_user['profile_image'] ? url($select_chat_user['profile_image']) : url('public/frontend/images/default-user.jpg') ;
	   $header_chat_details['user_name']  = $select_chat_user['username'] ? $select_chat_user['username'] : '';
	   $header_chat_details['chat_id']  = $select_chat_user['id'] ? $select_chat_user['id'] : '';
	   $header_chat_details['connection_id']  = $user_id ;
	  

	   $all_chat_details = DB::table('message_chat')
	   ->where(function ($query1) use ($user_id,$chatid){
		$query1->where('sender_id', '=', $user_id)
		->where('receiver_id', '=', $chatid);
	   })
		->orWhere(function ($query) use ($user_id,$chatid){
			$query->where('sender_id', '=', $chatid)
				->where('receiver_id', '=',  $user_id);
		})->orderBy('created_at', 'asc')->get();

		foreach($all_chat_details as $key => $single_chat){

			// print_r($single_chat);
			// die;
			if($single_chat->receiver_id == $user_id){
				DB::table('message_chat')->where('id', $single_chat->id)->update(['status' =>'R']);
			}
    	

			$sender_user = User::where('id',$single_chat->sender_id)->first();
			$receiver_user = User::where('id',$single_chat->receiver_id)->first();

			$all_chat_details[$key]->sender_name = $sender_user['username'];
			$all_chat_details[$key]->sender_profile_image = $sender_user['profile_image'] ? url($sender_user['profile_image']) : url('public/frontend/images/default-user.jpg') ;
			
			$all_chat_details[$key]->reciver_name = $receiver_user['username'];
			$all_chat_details[$key]->reciver_profile_image = $receiver_user['profile_image'] ? url($receiver_user['profile_image']) : url('public/frontend/images/default-user.jpg') ;
			$all_chat_details[$key]->own_send = $single_chat->sender_id == $user_id ? 1 : 0;
			
			$all_chat_details[$key]->addTime = $single_chat->created_at ? date('d M,Y h:i A', strtotime($single_chat->created_at)) : 0;
			
			// die;
		}
		// echo "<pre>";
		// print_r($all_chat_details);
		// die;
		if(!empty($all_chat_details)){
			return response()->json([
				'success' => true,
				'data'=>  $all_chat_details,
				'select_chat_user'=>  $header_chat_details,
				'message'=>'Chat Data found'
			], 200);
		}
		else{
			return response()->json([
				'success' => false,
				// 'data'=>  $all_user_array ,
				// 'html'=>  $html ,
				'message'=>'No data found'
			], 200);
		}
		

	}

	public function viewSave(Request $request)
	{
		$data =  $request->input();
		// echo "<pre>";
		// print_r($data);
		// die;

		$values = array(
			'sender_id' => Auth()->user()->id,
			'receiver_id' => $data['chat_id'],
			'message' => $data['message'],
			'status' => 'U'
		);
            DB::table('message_chat')->insert($values);

				return response()->json([
					'success' => true,
					'message'=>'Save Successfully'
				], 200);

	}
}

