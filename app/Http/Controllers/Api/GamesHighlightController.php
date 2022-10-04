<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Gamehighlight;

class GamesHighlightController extends Controller
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
          $user_id = $user->id;
            $data = Gamehighlight::where('status', '!=', 3)->where('user_id', $user_id)->get();
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
            'record_date' => 'required',
            'description' => 'required',
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
            $data = $request->only(            
                'description',
                'video'       
            );
            $data['record_date'] = date('Y-m-d', strtotime($request->input('record_date')));
            $data['user_id'] = $user_id;
            $data['status'] = 1;
            Gamehighlight::insert($data);

            return response()->json([
                                'success' => true,
                                'message' => "Data saved successfully."
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
        $id = $request->input('game_id');
        try{
            $data = Gamehighlight::find($id);
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
            'record_date' => 'required',
            'description' => 'required',
            'game_id' => 'required',
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
            $data = $request->only(            
                'description',
                'video'          
            );
            $data['record_date'] = date('Y-m-d', strtotime($request->input('record_date')));
            $data['status'] = $request->input('status');
            $id = $request->input('game_id');
            Gamehighlight::where('id', $id)->update($data);

            return response()->json([
                                'success' => true,
                                'message' => "Data updated successfully."
                            ], 200);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => "Failed to updated data."
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
        $id = $request->input('game_id');
        if(Gamehighlight::where('id', $id)->update(['status'=>3])){
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
}
