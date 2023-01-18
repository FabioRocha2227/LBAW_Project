<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;

use App\Models\ReactComment;

class ReactCommentController extends Controller{

    public function like(Request $request,$id_comment){
        $userId = Auth::id();
        // fetch the post with the specified id
        $comment = DB::table("comment")->where("id_comment", "=", $id_comment)->first();
        $postId =  $comment->id_post;
        $post = DB::table("post")->where("id", "=", $postId)->first();
        // fetch the user who made the post
        $userTo = $post->id_user;
      
        // check if the user has already liked the post
        $like = DB::table("react_comment")
          ->where("id_comment", "=", $id_comment)
          ->where("user_id", "=", $userId)
          ->first();
  
          $maxId = DB::table('react_comment')->max('id_react_comment'); 
          $maxId +=1;
          $react_comment_date = date("Y/m/d");
  
        if (is_null($like)) {
            DB::insert('insert into react_comment (id_react_comment, user_id, react_comment_date, id_comment, user_to) values (?,?, ?, ?, ? )',
             [$maxId, $userId, $react_comment_date, $comment->id_comment, $userTo]);
            return redirect()->back();
        } else {
          // delete the existing like
          DB::table("react_comment")
            ->where("id_comment", "=", $id_comment)
            ->where("user_id", "=", $userId)
            ->delete();
            return redirect()->back();
        }
      }
  

    public function add($id_user, $id_comment, $user_to){
        $rp = new ReactComment();
        $maxId = DB::table('react_comment')->max('id_react_comment'); 
        $rp->id_react_comment = $maxId +1;
        $rp -> user_id = $id_user;
        $rp -> react_comment_date = date("Y/m/d");
        $rp -> id_comment = $id_comment;
        $rp -> user_to = $user_to;
        DB::insert('insert into react_comment (id_react_comment, user_id, react_comment_date, id_comment, user_to) values (?,?, ?, ?, ? )', [$rp->id_react_comment, $rp->user_id, $rp->react_comment_date, $rp->id_comment, $rp->user_to]);
        return redirect()->back();

    }

    public function delete($id_user,$id_comment, $user_to){
        $rp = DB::table('react_comment')->where('id_comment' , $id_comment)->where('user_id', $id_user)->delete();
        return redirect()->back();
    }

    public static function countLikesComment($id_comment){
        $rp = DB::table('react_comment')->where('id_comment' , $id_comment)->get();
        return count($rp);
    }

}
