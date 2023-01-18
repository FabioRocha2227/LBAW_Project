<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Comment;

class CommentController extends Controller{

    public static function create(Request $request, $id_post){
        $comment = new Comment();
        $maxId = DB::table('comment')->max('id_comment'); 
        $comment->id_comment=$maxId +1;
        $comment->content = $request->input('done');
        $comment->id_user = Auth::user()->id;
        $comment->id_post = $id_post;
        $comment->comment_date = date("Y/m/d");
        $comment->comment_state = 0;
        DB::insert('insert into comment (id_comment,comment_state, content, comment_date, id_user, id_post) values (?,?,?,?,?,?)', [$comment->id_comment, $comment->comment_state, $comment->content, $comment->comment_date, $comment->id_user, $comment->id_post]);
        return redirect()->back();
    }

    public static function showComments($id_post){
        $comments = DB::table('comment')->where('id_post', $id_post)->where('comment_state',0)->get();
        return $comments;
    }

    public function delete($id)
    {
      $comment = DB::table('comment')->where('id_comment',$id)->update(array('comment_state' => 1));
      return redirect()->back();
    }
    public function admin($id)
    {
      $comment = DB::table('comment')->where('id_comment',$id)->update(array('comment_state' => 0));
      return redirect()->back();
    }

    public function update(Request $request, $id, $post)
    {
        $comment = DB::table('comment')->where('id_comment',$id)->update(array('comment_state' => 1));
        return redirect()->back();

    }

}