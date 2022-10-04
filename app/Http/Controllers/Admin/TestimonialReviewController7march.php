<?php

namespace App\Http\Controllers\admin;

//use DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//use App\Models\Page;
use App\Models\TestimonialReview;

class TestimonialReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonial_review = TestimonialReview::whereNotIn('status',['9'])->get();
        // dd($testimonial_review);

        //DB::enableQueryLog(); // Enable query log
        //// Your Eloquent query executed by using get()
        //dd(DB::getQueryLog()); // Show results of log

        return view('admin.testimonial-review.index')
                    ->with('testimonial_review', $testimonial_review);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.testimonial-review.addreview');
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
            'name' => 'required|max:255',
            'comments' => 'required',
            'image' => 'image|mimes:jpg,png,jpeg',
        ]);
        $data = $request->only(            
            'name',
            'comments'
        );
        if (request()->hasFile('image')) {
                $file = request()->file('image');
                $fileName = time() . "." . $file->getClientOriginalExtension();
                if($file->move('public/uploads/testimonial_review/', $fileName)){
                    $data['image'] = 'public/uploads/testimonial_review/'.$fileName;
                }
        }

        if($id = TestimonialReview::insert($data)){
            return redirect('/admin/testimonial-review')->with('success','Testimonial Review Added Successfully');
        }else{
            return back()->with('error', 'Failed to add new Testimonial Review');
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
        $testimonial_review = TestimonialReview::where('id', $id)->first();
        return view('admin.testimonial-review.editreview')
                //->with('banner', $banner)
                ->with('testimonial_review', $testimonial_review)                
                ;
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
            //'page_id' => 'required',
            'name' => 'required|max:255',
            'comments' => 'required',
            'status'=> 'required'
        ]);

        $testimonial_review = TestimonialReview::find( $id );
        //$banner->page_id = $request->input('page_id');
        $testimonial_review->name = $request->input('name');
        $testimonial_review->comments = $request->input('comments');
        $testimonial_review->status = $request->input('status');
        if (request()->hasFile('image')) {
                $file = request()->file('image');
                $fileName = time() . "." . $file->getClientOriginalExtension();
                if($file->move('public/uploads/testimonial_review/', $fileName)){
                    $testimonial_review->image = 'public/uploads/testimonial_review/'.$fileName;
                }
        }

        $testimonial_review->save();
        
        return redirect('/admin/testimonial-review')->with('success','Tastimonial Review Updated Successfully');
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = TestimonialReviewController::find( $id );
        $blog->status = 9;  //for delete
        $banner->save();
        
        return response()->json([
            'status' => true,
            'message' => 'Tastimonial Review deleted successfully',
        ]);
    }
}
