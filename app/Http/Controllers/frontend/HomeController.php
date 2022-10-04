<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Newsletter;
use App\Models\Blog;
use App\Models\Banner;
use App\Models\Feature;
use App\Models\Benefit;
use App\Models\Storie;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\TestimonialReview;
use App\Models\Fitness;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //echo app()->version();exit;
        $banner = Banner::where('status', 1)->where('id', 1)
                             ->first();
        $bloglist = Blog::where('status', 1)->limit(2)
                             ->get();
        $features1 = Feature::where('status', 1)->where('id', 1)
                             ->first();  
        $features2 = Feature::where('status', 1)->where('id', 2)
                            ->first();
        $features3 = Feature::where('status', 1)->where('id', 3)
                            ->first();
        $features4 = Feature::where('status', 1)->where('id', 4)
                            ->first(); 
        $benefits = Benefit::where('status', 1)->limit(9)
                            ->get(); 
        $lower_banner = Banner::where('status', 1)->where('id', 2)
                            ->first();
        $stories = Storie::where('status', 1)
                            ->first();  
        $services = Service::where('status', 1)
                            ->first();
        $testimonial_content = Testimonial::where('status', 1)
                            ->first();
        $testimonial_review = TestimonialReview::where('status', 1)->limit(3)
                            ->get();
        $fitness = Fitness::where('status', 1)->limit(3)
                            ->get();

        return view('frontend.home')
        ->with('bloglist',$bloglist)
        ->with('banner',$banner)
        ->with('features1',$features1)
        ->with('features2',$features2)
        ->with('features3',$features3)
        ->with('features4',$features4)
        ->with('benefits',$benefits)
        ->with('lower_banner',$lower_banner)
        ->with('stories',$stories)
        ->with('services',$services)
        ->with('testimonial_content',$testimonial_content)
        ->with('testimonial_review',$testimonial_review)
        ->with('fitness',$fitness);
    }
    public function newsletter_subscription(Request $request)
    {
        $request->validate([
            'email' => 'required'
        ]);
        try{
            $data = $request->only('email');
            $data['status'] = 1;

            if(Newsletter::insert($data)){            
                return redirect('')->with('success','Thanks for Subscribe');
             }else{
                    return back()->with('error', 'Failed to Subscribe');
            }
        }
        catch(\Exception $e)
        {
            return back()->with('error','Unable to send data');
        }
    }
}
