<?php

namespace App\Http\Controllers\Frontend\coach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Events;
use App\Models\State;
use App\Models\Sport;
use App\Models\City;
use Session;
use DB;
use Illuminate\Support\Facades\Hash;
class EventsController extends Controller
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
    public function index(Request $request)
    {      
        $search_details = '';
        if(!empty($request->input())){
        $category = [];
        $sports = [];
        $states = '';
        $category = $request->input('category');
        $sports = $request->input('sports');
        $states = $request->input('states');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $query = Events::whereIn('status', ['1','2','3'])->where('user_id', '!=', Auth()->user()->id);
        if(!empty($category)){
            $query = $query->whereIn('category', $category);
        }
        if(!empty($sports)){
            $query = $query->whereIn('sport', $sports);
        }
        if(!empty($states)){
            $query = $query->where('state', $states);
        }
        if(!empty($start_date)){
            $query = $query->where('start_date', '>=', $start_date);
        }
        if(!empty($end_date)){
            $query = $query->where('end_date', '<=', $end_date);
        }
        $data = $query->get();

        // dd($data);
        
        }else{
            $data = Events::where('status','!=', 3)->where('user_id', '!=', Auth()->user()->id)
            // ->with('address')
            ->get(); 
        }    
       $user_id= Auth()->user()->id;

        $athlete = User::where('role_id', 1)
        ->with('address')
        ->get(); 

        // $user_event = Events::where('status','!=', 3)->where('user_id', Auth()->user()->id)
        //     // ->with('address')
        //     ->get();
            
            $user_event =DB::table('events')
            ->join('sports','sports.id', '=', 'events.sport')
            ->join('event_categoris','event_categoris.id', '=', 'events.category')
            ->select('events.*','sports.name as sp_name','event_categoris.name as ev_name')
            ->where('events.status', '!=', 3)
            ->where('events.user_id', Auth()->user()->id)
             ->orderBy('start_date', 'DESC')
            ->get();  
       
        $states= State::where('country_id', 231)->get();
        
        $sport= Sport::where('status', 1)->get();

        $cat_event =DB::table('event_categoris')
        ->where('status', 1)
        ->get();     

       // echo $coach[4]->id.'||'. $coach[4]->address[0]->country_id;exit;           
        return view('frontend.coach.event.list')
        ->with('even_list', $data)->with('states', $states)->with('cat_event', $cat_event)->with('sport', $sport)->with('user_event', $user_event);
    }
    public function saveEvents(Request $request){
        $request->validate([
            'category' => 'required',
            'event_name' => 'required',
            'location' => 'required',
            'sport' => 'required',
            'city' => 'required',
            'state' => 'required|int',
            'start_date' => 'required',
            'end_date' => 'required',
            'even_details' => 'required|max:1000',
            'status' => 'required',
        ]);
        try{
            
            $user_id= Auth()->user()->id;
            $data = $request->only('category', 'event_name', 'location','sport', 'url', 'city', 'state', 'start_date', 'end_date', 'even_note', 'even_details','status');
            // dd($user->id);
            $data['user_id'] = $user_id;
            // dd($data);
             $st_date= $request->start_date;
            $end_date= $request->end_date;
            $data['start_date']= date('Y-m-d', strtotime($st_date));
            $data['end_date']= date('Y-m-d', strtotime($end_date));
            if (empty($request->eventId)) {
                if(Events::insert($data)){            
                return redirect('/coach/events')->with('success','Add Events Successfully');
                }else{
                    return back()->with('error', 'Failed to add event');
                }
            }else{
                if(Events::where('id', $request->eventId)->update($data)){            
                return redirect('/coach/events')->with('success','Events Updated Successfully');
                }else{
                    return back()->with('error', 'Failed to update event');
                }
            }

        }
        catch(\Exception $e)
        {
            return back()->with('error','Unable to save data');
        }
    }
    public function addEvents($id="")
    {      
       $user_id= Auth()->user()->id;

        $coach = User::where('role_id', 1)
        ->with('address')
        ->get(); 
        if (!empty($id)) {
           $data = Events::where('id', $id)  
            ->first();
            $states= State::all();
            $city="";
            if($data->state!=""){
                $city= city::where('state_id', $data->state)->get();
            }
            // dd($states);
            return view('frontend.coach.event.index')
        ->with('data', $data)
        ->with('states', $states)
        ->with('city', $city);
        }else{
            return view('frontend.coach.event.index');
        }
       // echo $coach[4]->id.'||'. $coach[4]->address[0]->country_id;exit;           
        
    }
    public function deleteEvents($id="")
    {      
       $user_id= Auth()->user()->id;
       $eventId=$id;
       if(Events::where('id', $eventId)->update(['status'=>3])){            
        // return redirect('/coach/events')->with('success','Events Deleted Successfully');
        return response()->json([
            'success' => true,
            'data'=> 'Event',
            'message'=>'Data Deleted Succesfully'
        ], 200);
        }else{
            return back()->with('error', 'Failed to delete event');
        }
    }
    public function detailsEvents(Request $request){
        //$event_details = Events::where('id', $request->event_id)->first();
        $event_details=Events::leftJoin('event_categoris', 'events.category', '=', 'event_categoris.id')->where('events.id', $request->event_id)
  ->first();
  $sport_name= Sport::find($event_details->sport);
  $state= State::find($event_details->state);
  $result= array(
    'data'=> $event_details,
    'sport_name'=> $sport_name,
    'state'=> $state

  );
        return response()->json([
            'success' => true,
            //'data'=> $event_details
            'data'=> $result
        ], 200);
    }
}