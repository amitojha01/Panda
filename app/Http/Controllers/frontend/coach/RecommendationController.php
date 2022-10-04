<?php

namespace App\Http\Controllers\Frontend\coach;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Recommendation;
use Illuminate\Support\Facades\Mail;
use App\Mail\RecommendMail;
use DB;


class RecommendationController extends Controller
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
        $user_id= Auth()->user()->id;
        //echo $user_id;exit;
        $recommended_user_list =DB::table('recommendation')
        ->leftjoin('users','recommendation.sender_id', '=', 'users.id')

        ->leftJoin('user_address','users.id', '=', 'user_address.user_id')

        ->leftJoin('countries','countries.id', '=', 'user_address.country_id')

         ->select('recommendation.id as recommend_id','recommendation.recommendation', 'recommendation.updated_recommendation', 'recommendation.reply_msg', 'recommendation.created_at','recommendation.status','users.username','users.profile_image',
            'countries.name as country_name')
        // ->where('recommendation.recommend_status', 1)
          ->where('recommendation.recommend_status','!=', 0)
         ->where('recommendation.receiver_id', $user_id)
         ->orderBy('recommendation.status', 'DESC')
         //->groupBy('users.id')
        ->get();

        return view('frontend.coach.recommendation.index')
        ->with('recommended_user_list', $recommended_user_list);
    }

    public function writeRecommendation($id){
        $detail = Recommendation::find( $id );
        return view('frontend.coach.recommendation.write-recommendations')
        ->with('recommed_id', $id)
        ->with('detail', $detail);;
    }
    
     


    public function sendRecommendation(Request $request){
        $recommendId= $request->recommendId;
        $recommend = Recommendation::find( $recommendId );
        $recommend->recommendation = $request->input('recommendation');
        $recommend->recommend_status = 1;
        $recommend->created_at = date('Y-m-d H:i:s');
        if($recommend->save()){
        return redirect('/coach/recommendation')->with('success','Recommended successfully');
    }
       
    }

    public function editRecommendation($id){
        $detail = Recommendation::find( $id );
        //print_r($detail);exit;
        return view('frontend.coach.recommendation.edit-recommendations')
        ->with('recommed_id', $id)
        ->with('detail', $detail);;
    }

    public function updateRecommendation(Request $request){       
        $recommendId= $request->recommendId;
        $recommend = Recommendation::find( $recommendId );
        //$recommend->recommendation = $request->input('recommendation');
        $recommend->updated_recommendation = $request->input('recommendation');
        $recommend->recommend_status = 1;
        $recommend->athlete_read_status = 0;
        //$recommend->created_at = date('Y-m-d H:i:s');
        if($recommend->save()){
        return redirect('/coach/recommendation')->with('success','Updated successfully');
    }
       
    }


    public function declineRecommendation(Request $request){
         $recommendId= $request->recommendationId;
         $recommend = Recommendation::find( $recommendId );

         $recommend->decline_reason = $request->decline_reason;
         $recommend->recommend_status = 2;
          if($recommend->save()){
        return redirect('/coach/dashboard')->with('success','Declined successfully');
    }

    }

    public function getReplymsg(Request $request){
       
        $recommendId= $request->recomend_id;
       
         $recommend = Recommendation::find( $recommendId );
         return response()->json($recommend);

    }



    
}
