<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use App\Models\Events;
use App\Models\Sport;
use App\Models\State;
use App\Models\EventCategory;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $user = auth('api')->user();
            $data = Events::where('status', '!=', 3)
                            ->where('user_id', $user->id)
                            ->get();
            $allEvent = [];
            $temp = [];
            foreach($data as $value){
                // print_r($value['id']);
                // die;
                // "id": 1,
                $category_details = EventCategory::where('id', $value['category'])->first();
                $sport_details = Sport::where('id', $value['sport'])->first();

                $temp["id"] = $value['id'];
                $temp["category_id"] = $value['category'];
                $temp["category_name"] = $value['category'];
                $temp["event_name"] =$category_details->name;
                $temp["location"] = $value['location'];
                $temp["sport_id"] = $value['sport'];
                $temp["sport_name"] = $sport_details->name;
                $temp["city"] = $value['city'];
                $temp["state"] = $value['state'];
                $temp["url"] = $value['url'];
                $temp["start_date"] = $value['start_date'];
                $temp["end_date"] = $value['end_date'];
                $temp["even_note"] = $value['even_note'];
                $temp["even_details"] = $value['even_details'];
                $temp["status"] = $value['status'];
                $temp["created_at"] = $value['created_at'];
                $temp["updated_at"] = $value['updated_at'];
                $allEvent[] = $temp;
            }


            return response()->json([
                'success' => true,
                'data'=> $allEvent
            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => true,
                'message' => 'Unable to get request data',
                'data'=> []
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();
        $validator = Validator::make($data, [
            'category' => 'required',
            'event_name' => 'required|unique:events,event_name',
            'location' => 'required',
            'sport' => 'required|int',
            'city' => 'required|int',
            'url'=> 'required',
            'state' => 'required|int',
            'start_date' => 'required',
            'end_date' => 'required',
            'even_note' => 'required',
            'even_details' => 'required|max:1000',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            $err= $validator->errors();
            $err_msg = '';
            foreach(json_decode($err) as $key=> $val){
                $err_msg = $val[0];
                break;
            }
            return response()->json([
                'success' => false,
                'error' => $err_msg
            ], 422);
        }
        try{            
            $user_id= auth('api')->user()->id;
            $data = $request->only('category', 'event_name', 'location', 'sport', 'city', 'url', 'state', 'start_date', 'end_date', 'even_note', 'even_details','status');
            // dd($user->id);
            $data['user_id'] = $user_id;
            Events::insert($data);

            return response()->json([
                                'success' => true,
                                'message' => "Event saved successfully."
                            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to saved data."
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->input('event_id');
        try{
            $data = Events::find($id);
           
            $data->state_name = '';
            if($data){
                $xx = State::find($data->state);
                if($xx ){
                    $data->state_name = $xx->name;
                }
                $category = EventCategory::find($data->category);
                if( $category ){
                    $data->category_name = $category->name;
                }
                $sport_details = Sport::find($data->sport);
                if( $category ){
                    $data->sport_name = $sport_details->name;
                }
            }
            return response()->json([
                'success' => true,
                'data'=> $data
            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => true,
                'message' => 'Unable to get request data',
                'data'=> []
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'category' => 'required',
            'event_name' => 'required|unique:events,event_name',
            'location' => 'required',
            'sport' => 'required|int',
            'city' => 'required|int',
            'url'=> 'required',
            'state' => 'required|int',
            'start_date' => 'required',
            'end_date' => 'required',
            'even_note' => 'required',
            'even_details' => 'required|max:1000',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            $err= $validator->errors();
            $err_msg = '';
            foreach(json_decode($err) as $key=> $val){
                $err_msg = $val[0];
                break;
            }
            return response()->json([
                'success' => false,
                'error' => $err_msg
            ], 422);
        }
        try{
            $id = $request->input('event_id');

            $data = $request->only('category', 'event_name','location', 'sport', 'city', 'url', 'state','start_date', 'end_date', 'even_note', 'even_details','status');

            Events::where('id', $id)->update($data);

            return response()->json([
                                'success' => true,
                                'message' => "Event update successfully."
                            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to update data."
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->input('event_id');
        if(Events::where('id', $id)->update(['status'=>3])){
            return response()->json([
                    'success' => true,
                    'message'=>'Data Deleted Succesfully'
                ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => "Failed to delete data."
            ], 500);
        }
    }

    public function getEventCategory()
    {
        $data = EventCategory::all();
        return response()->json([
            'success' => true,
            'data'=> $data
        ], 200);
    }

    public function eventOpportunities(Request $request)
    {
        // try{
            $id = auth('api')->user()->id;

                $event_data = Events::where('status','!=', 3)->where('user_id', '!=', $id)
                // ->with('address')
                ->get(); 
                $allEvent = [];
                $temp = [];
                foreach($event_data as $value){
                    // print_r($value['id']);
                    // die;
                    // "id": 1,
                    $category_details = EventCategory::where('id', $value['category'])->first();
                    $sport_details = Sport::where('id', $value['sport'])->first();

                    $temp["id"] = $value['id'];
                    $temp["category_id"] = $value['category'];
                    $temp["category_name"] = $value['category'];
                    $temp["event_name"] =$category_details->name;
                    $temp["location"] = $value['location'];
                    $temp["sport_id"] = $value['sport'];
                    $temp["sport_name"] = $sport_details->name;
                    $temp["city"] = $value['city'];
                    $temp["state"] = $value['state'];
                    $temp["url"] = $value['url'];
                    $temp["start_date"] = $value['start_date'];
                    $temp["end_date"] = $value['end_date'];
                    $temp["even_note"] = $value['even_note'];
                    $temp["even_details"] = $value['even_details'];
                    $temp["status"] = $value['status'];
                    $temp["created_at"] = $value['created_at'];
                    $temp["updated_at"] = $value['updated_at'];
                    $allEvent[] = $temp;
                }

                return response()->json([
                        'success' => true,
                        'data' => $allEvent,
                        'message'=>'Succesfully'
                    ], 200);
            
        // }
        // catch(\Exception $e)
        // {
        //     return response()->json([
        //         'success' => false,
        //         'message' => "Failed"
        //     ], 500);
        // }
    }
}
