<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Newsletter;
use DB;

class NewsletterController extends Controller
{

    public function index()
    {
        //$newsletter = Newsletter::all();
        $newsletter = Newsletter::whereIn('status', [0, 1])
                    ->orderBy('id', 'DESC')
                    ->get();
        return view('admin.newsletter.index')
        ->with('newsletter', $newsletter);
    }   


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyNewsletterz($newsletter_id)
    {       
        DB::table('newsletters')->delete($newsletter_id);
        return back()->with('success','Deleted Successfully');
    } 
    
     public function destroyNewsletter($id)
    {
        $newsletter = Newsletter::find( $id );
        $newsletter->status = 9;
        $newsletter->save();
        
        return response()->json([
            'status' => true,
            'message' => 'Deleted successfully',
        ]);
    }

}
