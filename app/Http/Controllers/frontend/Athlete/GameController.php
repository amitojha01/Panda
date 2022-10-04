<?php

namespace App\Http\Controllers\Frontend\Athlete;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gamehighlight;
use DB;


class GameController extends Controller
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
        $game = Gamehighlight::where('user_id', $user_id) 
        ->orderBy('id', 'DESC')
        ->get();
        return view('frontend.athlete.game.index')
        ->with('game', $game);       
    }

    public function addGame(){
        return view('frontend.athlete.game.add-game-highlights'); 

    }
    
    public function storeGamehighlights(Request $request)
    {
        $request->validate([
            'record_date' => 'required',
            'description' => 'required',
        ]);
        $data = $request->only(            
            'description',
            'video' ,
            'video_embeded_link'        
        );
        $data['record_date'] = date('Y-m-d', strtotime($request->input('record_date')));
        $data['user_id'] = Auth()->user()->id;
        $data['status'] = 1;
        
        if($id = Gamehighlight::insert($data)){
            
            return redirect('/athlete/game-highlights')->with('success','Game Highlights Added Successfully');
        }else{
            return back()->with('error', 'Failed to add new game highlights');
        }
    }

    public function editGamehighlights($id)
    {
        $game = Gamehighlight::where('id', $id)
        ->first();        
        return view('frontend.athlete.game.edit-game-highlights')
        ->with('game', $game);
    }

    public function updateGamehighlights(Request $request, $id)
    {
        $request->validate([
            'record_date' => 'required',
            'description' => 'required',
        ]);

        $data = $request->only(            
            'description',
            'video'         
        );
        $data['record_date'] = date('Y-m-d', strtotime($request->input('record_date')));
        
        $game = Gamehighlight::find( $id );
        $game->record_date = date('Y-m-d', strtotime($request->input('record_date')));
        $game->description = $request->input('description');
        $game->video = $request->input('video');
        $game->video_embeded_link = $request->input('video_embeded_link');
        

        if($game->save()){
            return redirect('/athlete/game-highlights')->with('success','Game Highlights Updated Successfully');
        }else{
            return back()->with('error', 'Failed to add new game highlights');
        }
    }

    public function deleteGamehighlights($id="")
    { 
     $gameId=$id;
     if(DB::table('game_highlights')->delete($gameId)){  
         return response()->json([
            'status' => true,
            'message' => 'Deleted successfully',
        ]);
         
     }else{
        return back()->with('error', 'Failed to delete member');
    }
}
}
