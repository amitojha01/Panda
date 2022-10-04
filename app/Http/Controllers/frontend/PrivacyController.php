<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Cms;

class PrivacyController extends Controller
{
    
    public function __construct()
    {
        //$this->middleware('auth');
    }
    
    public function index()
    {
    	$banner = Banner::where('page_id', 5)
                            ->with('page')
                            ->first();
                            
        $content = Cms::where('page_id', 5)
                             ->get();

        return view('frontend.privacy',['banners' => $banner, 'cms' => $content]);
    }
}
