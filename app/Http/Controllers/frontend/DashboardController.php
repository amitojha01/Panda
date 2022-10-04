<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Order;
use App\Models\Favourite;
use Illuminate\Support\Facades\Hash;
use Session;
use DB;
use Auth;

class DashboardController extends Controller
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

    
    public function index()
    {  
        if(session()->has('user')){
            $userId= Session::get('user')['userId'];     
        $userdetail = DB::table('users')->where('id', $userId)->first();         
        $countrydetail = DB::table('countries')->where('id', $userdetail->country)->first(); 
        $statedetail=  DB::table('states')->where('id', $userdetail->state)->first();
        $citydetail=  DB::table('cities')->where('id', $userdetail->city)->first(); 

        return view('frontend.dashboard')
        ->with('userdetail', $userdetail)
        ->with('countrydetail', $countrydetail) 
        ->with('statedetail', $statedetail)  
        ->with('citydetail', $citydetail); 

        }else{
            return redirect('/sign-in');
        }
            
    }

    //====Edit Profile======
    public function edit($id)
    {
        $userdetail = User::where('id', $id)
        ->first();

        $statedetail=  DB::table('states')->where('id', $userdetail->state)->first();
        $citydetail=  DB::table('cities')->where('id', $userdetail->city)->first(); 

        $countries = DB::table('countries')->get();

 
        $states = DB::table('states')->where('country_id', $userdetail->country)->get();
        $city = DB::table('cities')->where('state_id', $userdetail->state)->get();
    
        return view('frontend.edit-profile')
        ->with('countries', $countries)
        ->with('statedetail', $statedetail)  
        ->with('citydetail', $citydetail)

        ->with('states', $states)
        ->with('cities', $city)
        ->with('userdetail', $userdetail);
    }

    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        $user = User::find( $id );
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');
        $user->country = $request->input('country');
        $user->state = $request->input('state');
        $user->city = $request->input('city');
        $user->pin_code = $request->input('pin_code');

        $user->save();  
        return back()->with('success','Profile Updated Successfully!!'); 
    }
    
    public function orderList()
    {
        $userId= Session::get('user')['userId']; 
        $orderlist =  Order::where('user_id', $userId)
        ->orderBy('id', 'DESC')
        ->get();   

        return view('frontend.order-listing')
        ->with('orderlist', $orderlist);
    }

    public function orderDetail($id)
    {

       $orderdetail = Order::where('id', $id)
       ->first();     

       return view('frontend.order-detail')
       ->with('order', $orderdetail);
   }

   public function changePassword()
   {
    $userId= Session::get('user')['userId'];  
    return view('frontend.change-password');
}   

public function updatePassword(Request $request)
{  
    $id= Session::get('user')['userId'];  
    $user = User::find( $id );    

    $new_pwd = $request->input('new_password');
    $confirm_pwd = $request->input('confirm_password');
    $user->password = Hash::make($new_pwd);        
    $data = $request->all();

    if($new_pwd!= $confirm_pwd){
        return back()->with('error','Password not match!!');
    }

    if(!\Hash::check($data['old_password'], auth()->user()->password)){        

     return back()->with('error','You have entered wrong password');

 }else{  
     $user->save();   
     return back()->with('success','Password Updated successfully!!');

 }
}

public function makeFavourite(Request $request)
{
 $has_favourite = Favourite::where('user_id', Auth()->user()->id)
 ->where('product_id', $request->input('product_id'))
 ->first();
 if(!empty($has_favourite)){
    $has_favourite->delete();
    $msg = 'Removed from favourite list';
}else{
    Favourite::insert([
        'product_id'=> $request->input('product_id'),
        'user_id'=> Auth()->user()->id
    ]);
    $msg = 'Added in favourite list';
}

return response()->json([
    'success' => true,
    'message' => $msg,
]);
}

}
