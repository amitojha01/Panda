<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Kreait\Firebase;

use Kreait\Firebase\Factory;

use Kreait\Firebase\ServiceAccount;

use Kreait\Firebase\Database;

// use Illuminate\Routing\Controller as BaseController;


class FirebaseController extends Controller

{


	public function index(){

		$factory = (new Factory)->withServiceAccount(__DIR__.'/mypandatest-firebase-adminsdk-kplpd-81e56f4508.json')->withDatabaseUri('https://mypandatest-default-rtdb.firebaseio.com');

		$database = $factory->createDatabase();
 		$newPost  = $database

		                    ->getReference('1-2')

		                    ->push([
		                    		'sender_id' => '1',
		                    		'sender_name'=>'ABC',
		                    		'sender_image'=>'',
		                    		'receiver_id'=>'2',
		                    		'receiver_name'=>'',
		                    		'receiver_image'=>'',
		                    		'message' => 'Hi',
		                    		'file'=>'',
		                    		'timestamp'=>date('Y-m-d')
		                    	]
		                    	);

		echo"<pre>";
		print_r($newPost->getvalue());
	die;

	}

	public function getdata()
	{
		$factory = (new Factory)->withServiceAccount(__DIR__.'/mypandatest-firebase-adminsdk-kplpd-81e56f4508.json')->withDatabaseUri('https://mypandatest-default-rtdb.firebaseio.com');

		$database = $factory->createDatabase();

		$newPost 		  = $database

		                    ->getReference('1-2');

		                    echo"<pre>";

		print_r($newPost->getvalue());

	}

}

?>