<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;

use App\Models\ReactPost;

class ReactPostController extends Controller{
    public function add($id_user, $id_post, $user_to){
        $rp = new ReactPost();
        $maxId = DB::table('react_post')->max('id_react_post'); 
        $rp->id_react_post = $maxId +1;
        $rp -> user_id = Auth::user()->id;
        $rp -> react_post_date = date("Y/m/d");
        $rp -> id_post = $id_post;
        $rp -> user_to = $user_to;
        DB::insert('insert into react_post (id_react_post, user_id, react_post_date, id_post, user_to) values (?,?, ?, ?, ? )', [$rp->id_react_post, $rp->user_id, $rp->react_post_date, $rp->id_post, $rp->user_to]);
        return redirect()->back();

    }

    public function delete($id_user,$id_post, $user_to){
        $rp = DB::table('react_post')->where('id_post' , $id_post)->where('user_id', $id_user)->delete();
        return redirect()->back();
    }

    public static function countLikes($id_post){
        $rp = DB::table('react_post')->where('id_post' , $id_post)->get();
        return count($rp);
    }
}