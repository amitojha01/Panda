<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    public function index()
    {
        $detail = User::where('role_id', 0)
        ->get();
    
        return view('admin.change_password')
        ->with('detail', $detail);
    }


    
    public function changePassword(Request $request, $id)
    {  
        $user = User::find( $id );    

        $new_pwd = $request->input('new_password');
        $confirm_pwd = $request->input('confirm_password');
        $user->password = Hash::make($new_pwd);        
        $data = $request->all();

        if (request()->hasFile('image')) {
                $file = request()->file('image');
                $fileName = time() . "." . $file->getClientOriginalExtension();
                if($file->move('public/uploads/profile/', $fileName)){
                    $user->profile_image = 'public/uploads/profile/'.$fileName;
                }
        }

        if($new_pwd!= $confirm_pwd){
            return back()->with('error','Password not match!!');
        }

        if(!\Hash::check($data['old_password'], auth()->user()->password)){        

           return back()->with('error','You have entered wrong password');

       }else{  
           $user->save();   
           return back()->with('success','Password Changed successfully!!');
           
       }
   }

   public function updateProfileImage(Request $request, $id)
    {  
        $user = User::find( $id ); 
               
        $data = $request->all();

        if (request()->hasFile('image')) {
                $file = request()->file('image');
                $fileName = time() . "." . $file->getClientOriginalExtension();
                if($file->move('public/uploads/profile/', $fileName)){
                    $user->profile_image = 'public/uploads/profile/'.$fileName;
                }
                $user->save();   
           return back()->with('success','Updated successfully!!');
        }       
   }

}
