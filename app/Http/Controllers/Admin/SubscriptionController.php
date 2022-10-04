<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Subscription;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscription = Subscription::whereIn('status', [0, 1])
                    ->orderBy('id', 'DESC')
                    ->get();
        
        return view('admin.subscription.index')
                    ->with('subscription', $subscription);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subscription.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        //echo "kk";exit;
        $sub_code = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);

        $request->validate([
            'name' => 'required',            
            'type' => 'required',            
        ]);
        $data = $request->only('name','type');
        $data['subscription_code'] = $sub_code;
        $data['user_limit'] = $request->input('user_limit');
        $data['monthly_amount'] = $request->input('monthly_amount');
        $data['yearly_amount'] = $request->input('yearly_amount');
        $data['content'] = $request->input('content');               
        $data['status'] = 1;
        if(Subscription::insert($data)){           
            return redirect('/admin/subscription')->with('success','Subscription Added Successfully');
        }else{          
            return back()->with('error', 'Failed to add new subscription');
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
        $subscription = Subscription::where('id', $id)
                            ->first();
        
        return view('admin.subscription.edit')
                ->with('subscription', $subscription);
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
            'name' => 'required|max:255',          
            'type' => 'required',
        ]);
               
        $subscription = Subscription::find( $id );
        $subscription->name = $request->input('name');
        $subscription->monthly_amount = $request->input('monthly_amount');
        $subscription->yearly_amount = $request->input('yearly_amount');
        $subscription->content = $request->input('content');
        $subscription->type = $request->input('type');
        $subscription->user_limit = $request->input('user_limit');
        $subscription->subscription_code = $request->input('subscription_code');
        $subscription->status = $request->input('status');

        $subscription->save();
        
        return redirect('/admin/subscription')->with('success','Subscription Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subscription = Subscription::find( $id );
        $subscription->status = 9;
        $subscription->save();
        
        return response()->json([
            'status' => true,
            'message' => 'Deleted successfully',
        ]);
    }
}
