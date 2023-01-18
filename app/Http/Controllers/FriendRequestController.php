<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\FriendRequest;
use App\Models\Friend;

class FriendRequestController extends Controller{

    public function add($user_from, $user_to){
        $fr = new FriendRequest();
        $fr->user_from = $user_from;
        $fr->user_to = $user_to;
        $fr->requested = 1;
        $fr->save();
        return redirect('/');
    }

    public function accept($id){
        $fr = FriendRequest::find($id);
        $fr -> accepted = 1;
        $fr -> requested = 0;
        $fr -> save();

        DB::insert('insert into friend (user_from, user_to) values (?, ?)', [$fr->user_from, $fr->user_to]);
        
        
        return redirect()->back();
    }

    public function reject($id){
        $fr = FriendRequest::find($id);
        $fr -> refused = 1;
        $fr -> requested = 0;
        $fr -> save();
        return redirect()->back();
    }

    public function delete($user_from, $user_to){
        $friend = DB::table('friend')->where('user_from', $user_from)->where('user_to', $user_to)->delete();
        $friend = DB::table('friend')->where('user_from', $user_to)->where('user_to', $user_from)->delete();
        return redirect('/');
    
    }
}