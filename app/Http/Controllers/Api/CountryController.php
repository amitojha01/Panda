<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Country;
class CountryController extends Controller
{
    //
    public function index(){
        return response()->json([
            'success' => true,
            'data'=> Country::all()
        ], 200);
    }
}
