<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EmailCoach;
use App\Models\Sport;
use App\Models\College;
use Session;


class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  
        $coachName= Session::get('searchcoach');
        if($coachName!=""){
            $emaillist = EmailCoach::where('name','LIKE','%'.$coachName.'%')->orwhere('school','LIKE','%'.$coachName.'%')->take(90)->orderBy('name', 'ASC')->paginate(20);

         }else{
            $emaillist = EmailCoach::take(20)->orderBy('id', 'ASC')->paginate(20);
         }
                          
        return view('admin.coachemail.index')
                    ->with('emaillist', $emaillist);
                   
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coachemail.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          $request->validate([
            'sport' => 'required',
            'gender' => 'required',
            'school' => 'required',
            'name' => 'required',
            'title' => 'required',
           // 'email' => 'required',
        ]);
        
        $data = $request->only(            
            'sport',
            'gender',
            'school',
            'name',
            'title',
            'email'
        );
        
        if(EmailCoach::insert($data)){
            return redirect('/admin/email')->with('success','Added Successfully');
        }else{
            return back()->with('error', 'Failed to add new coach email');
        }
    }
    
    
    public function destroy($id)
    {
        EmailCoach::where('id', $id)->delete();
                
        return response()->json([
            'status' => true,
            'message' => 'Deleted successfully',
        ]);
    }

     public function search()
    {

        $sport = EmailCoach::groupBy('sport')->get();
        $college_list= EmailCoach::groupBy('school')->get(); 
        return view('admin.coachemail.search')
        ->with('sport',  $sport)
        ->with('college_list',  $college_list);
        
    }

    public function searchCoach(Request $request)
    {

       $sports = $request->input('sport');
       $school= $request->input('school');
       $gender= $request->input('gender');
       $coachName = $request->input('coachName');
      
      
       if($coachName!=""){ 
        session()->put('searchcoach', $coachName);
            
         $result = EmailCoach::where('name','LIKE','%'.$coachName.'%')->take(90)->orderBy('name', 'ASC')->get();
         
       }else{
        $result = EmailCoach::whereIn('sport', $sports)->where('school', $school)->take(90)->where('gender', $gender)->orderBy('name', 'ASC')->get();
       }      

       return view('admin.coachemail.coach-list')
       ->with('result', $result);
   }

   public function searchByCon(Request $request)
    {
       
       $coachName = $request->input('coachName');
      
      
       if($coachName!=""){ 
        session()->put('searchcoach', $coachName);
            
         $result = EmailCoach::where('name','LIKE','%'.$coachName.'%')->orwhere('school','LIKE','%'.$coachName.'%')->take(90)->orderBy('name', 'ASC')->get();
         
       }     

       return view('admin.coachemail.coach-list')
       ->with('result', $result);
   }

   

 
     public function edit($id)
    {   

        $result = EmailCoach::where('id', $id)
        ->first();
                
        return view('admin.coachemail.edit')
        ->with('result', $result);
        
    }

     public function update(Request $request, $id)
    {
         $request->validate([
            'sport' => 'required',
            'gender' => 'required',
            'school' => 'required',
            'name' => 'required',
            'title' => 'required',
            
        ]);
        
        $data = $request->only(            
            'sport',
            'gender',
            'school',
            'name',
            'title',
            'email'
        );
        if(EmailCoach::where($data)->where('id', '!=', $id)->get()->count() > 0){
            return back()->with('error', 'Confernce already Exit');
        }
        $res = EmailCoach::find( $id );
        $res->sport = $request->input('sport');
        $res->gender = $request->input('gender');
        $res->school = $request->input('school');
        $res->name = $request->input('name');
        $res->title = $request->input('title');
        $res->email = $request->input('email');
        $res->save();       
        
        return redirect('/admin/email')->with('success','Updated Successfully');
    }

    public function reset(){
        session()->forget('searchcoach');
        return redirect('/admin/email')->with('success','Reset Successfully');
    }
      

    
   
}
