<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Banner;
use App\Models\Cms;
use App\Models\Contact;
use App\Models\Blog;
use App\Models\User;


class BlogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    
    public function index()
    { 
        // $banner = Banner::where('page_id', 3)
        //                     ->with('page')
        //                     ->first(); 

        $bloglist = Blog::where('status', 1)
                             ->get();
        $latestbloglist = Blog::where('status', 1)->limit(5)
        ->get();
        // return view('frontend.contact',['banners' => $banner, 'cms' => $content]);      
        return view('frontend.blogs-list')
        ->with('bloglist',$bloglist)     
        ->with('latestbloglist',$latestbloglist);      
    }
    public function blog_details($id="")
    { 
        $blogs = Blog::where('id', $id)->first(); 

        // $content = Cms::where('page_id', 3)
        //                      ->get();

        // return view('frontend.contact',['banners' => $banner, 'cms' => $content]);      
        return view('frontend.blogs-details')
        ->with('blogs',$blogs);      
    }

     public function save_contact(Request $request)
    {    

     $data = $request->only(
            'first_name',
            'last_name',
            'email',
            'phone',
            'subject',
            'message'
        );  
        if(Contact::insert($data)){
            return back()->with('success','Thank you for contacting us we will reply as soon as possible!!');           

        }              

                
   }


   

    

}
