<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\WorkoutCategory;
use App\Models\WorkoutLibrary;
use App\Models\WorkoutCategoryLibrary;
use DB;


class WorkoutCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cat_data = WorkoutCategory::whereIn('status', [0, 1])
        ->orderBy('id', 'DESC')
        ->get();
        
        return view('admin.workout-cat.index')
        ->with('cat_data', $cat_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $library = WorkoutLibrary::whereIn('status', [0, 1])
        ->orderBy('id', 'DESC')
        ->get();
        return view('admin.workout-cat.add')
        ->with('library', $library);
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
            'category_title' => 'required',
        ]);
        $data = $request->only(            
            'category_title',            
            'content_title',
            'description'
        );

        if(WorkoutCategory::where($data)->where('status', '!=', 9)->get()->count() > 0){
            return back()->with('error', 'Workout Category already Exist');
        }
        $data['status'] = 1;

        if (request()->hasFile('image')) {
            $file = request()->file('image');
            $fileName = time() . "." . $file->getClientOriginalExtension();
            if($file->move('public/uploads/images/', $fileName)){
                $data['image'] = 'public/uploads/images/'.$fileName;
            }
        } 
        if (request()->hasFile('banner')) {
            $file = request()->file('banner');
            $fileName = time() . "." . $file->getClientOriginalExtension();
            if($file->move('public/uploads/workout/images/', $fileName)){
                $data['banner'] = 'public/uploads/workout/images/'.$fileName;
            }
        } 

        $category_id= WorkoutCategory::insertGetId($data);

        if($category_id){
           if($library_ids= $request->input('library')){
            for($i=0; $i<count($library_ids);$i++){
                $lib_data=array(
                    'workout_category_id'=> $category_id,
                    'workout_library_id' => $library_ids[$i]
                );
                WorkoutCategoryLibrary::insert($lib_data);
            }
        }
        return redirect('/admin/workoutcategory')->with('success',' Added Successfully');
    }else{
        return back()->with('error', 'Failed to add new category');
    }
}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cat_data = WorkoutCategory::where('id', $id)
        ->first();
        $library = WorkoutLibrary::whereIn('status', [0, 1])
        ->orderBy('id', 'DESC')
        ->get();

         $workout_library = WorkoutCategoryLibrary::where('workout_category_id', $id)        
        ->get();
        
        return view('admin.workout-cat.edit')
        ->with('cat_data', $cat_data)
        ->with('library', $library)
        ->with('workout_library', $workout_library);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_title' => 'required',
        ]);
        $data = $request->only(            
            'category_title',            
            'content_title',
            'description'
        );  


        $workoutcategory = WorkoutCategory::find( $id );
        $workoutcategory->category_title = $request->input('category_title');
        $workoutcategory->content_title = $request->input('content_title');
        $workoutcategory->description = $request->input('description');
        $workoutcategory->status = $request->input('status');

        /*if($library_array= $request->input('library')){
            $lib_id= implode(',', $library_array);
            //$data['library_id']= $lib_id;
            $workoutcategory->library_id = $lib_id;
        }*/

        if (request()->hasFile('image')) {
            $file = request()->file('image');
            $fileName = time() . "." . $file->getClientOriginalExtension();
            if($file->move('public/uploads/workout/images/', $fileName)){
                $workoutcategory->image = 'public/uploads/workout/images/'.$fileName;
            }
        } 
        if (request()->hasFile('banner')) {
            $file = request()->file('banner');
            $bannerName = time() . "." . $file->getClientOriginalExtension();
            if($file->move('public/uploads/workout/images/', $bannerName)){
                $workoutcategory->banner = 'public/uploads/workout/images/'.$bannerName;
            }
        }       


        $workoutcategory->save();

         $cat_lib = WorkoutCategoryLibrary::where('workout_category_id', $id)
            ->get();

            if(count($cat_lib)>0){
                DB::table('workout_category_librarys')->where('workout_category_id', $id)->delete();
                if($library_ids= $request->input('library')){
                    for($i=0; $i<count($library_ids);$i++){
                        $lib_data=array(
                            'workout_category_id'=> $id,
                            'workout_library_id' => $library_ids[$i]
                        );
                        WorkoutCategoryLibrary::insert($lib_data);
                    }
                }
            }else{
                if($library_ids= $request->input('library')){
                    for($i=0; $i<count($library_ids);$i++){
                        $lib_data=array(
                            'workout_category_id'=> $id,
                            'workout_library_id' => $library_ids[$i]
                        );
                        WorkoutCategoryLibrary::insert($lib_data);
                    }
                }
            }
        
        return redirect('/admin/workoutcategory')->with('success','Category Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $workoutcategory = WorkoutCategory::find( $id );
        $workoutcategory->status = 9;
        $workoutcategory->save();
        
        return response()->json([
            'status' => true,
            'message' => 'Deleted successfully',
        ]);
    }
}
