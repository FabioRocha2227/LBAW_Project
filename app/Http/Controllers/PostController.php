<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Post;


class PostController extends Controller
{
    /**
     * Shows all posts.
     *
     * @return Response
     */
    public function list()
    {
      if (!Auth::check()) return redirect('/login');
      return view('pages.posts');
    }

    /**
     * Creates a new post.
     * @return post The post created.
     */
    
    public function create(Request $request)
    {
      $public = UserController::ispublic();
      if($public){
        $value = 1;
      }else{
        $value = 0;
      }
      $post = new post();
      $this->authorize('create', $post);
      $maxId = DB::table('post')->max('id'); 
      $post->id=$maxId +1;
      $post->id_user = Auth::user()->id;
      $post->content = $request->input('content');
      $post->post_state = 0;
      $post->post_date = date("Y/m/d");
      $post->ispublic = $value;
      $post->id_groups = 0;
      $post->save();
      return redirect()->back();
    } 

    
    public function update(Request $request, $id)
    {
      $this->delete($id);
      $post = new post();
      $maxId = DB::table('post')->max('id'); 
      $post->id = $maxId +1;
      $post->id_user = Auth::user()->id;
      $post->content = $request->input('done');
      $post->post_state = 0;
      $post->post_date = date("Y/m/d");
      $post->ispublic = 1;
      $post->id_groups = 0;
      $post->save();
      return redirect('/login');
    }
    
//likes



    public function like(Request $request,$id_post){
      $postId = $id_post;
      $userId = Auth::id();
      // fetch the post with the specified id
      $post = DB::table("post")->where("id", "=", $postId)->first();
    
      // fetch the user who made the post
      $userTo = $post->id_user;
    
      // check if the user has already liked the post
      $like = DB::table("react_post")
        ->where("id_post", "=", $postId)
        ->where("user_id", "=", $userId)
        ->first();

        $maxId = DB::table('react_post')->max('id_react_post'); 
        $maxId +=1;
        $react_post_date = date("Y/m/d");

      if (is_null($like)) {
        DB::insert('insert into react_post (id_react_post, user_id, react_post_date, id_post, user_to) values (?,?, ?, ?, ? )', 
        [$maxId, $userId, $react_post_date, $postId, $userTo]);
        return redirect()->back();
      } else {
        // delete the existing like
        DB::table("react_post")
          ->where("id_post", "=", $postId)
          ->where("user_id", "=", $userId)
          ->delete();
          return redirect()->back();
      }
    }



 
      

    public function delete($id)
    {

      $item = post::find($id);
      $item -> post_state = '1';
      $item->save();
      return redirect()->back();
    }

    public function adminPost($id){
      $item = post::find($id);
      $item -> post_state = '0';
      $item->save();
      return redirect()->back();
    }

    public static function showPosts($user_id){
      $friend = DB::table('friend')->get();
      $filter_friend = $friend->filter(function($value,$key){
          return $value -> user_from == Auth::user()->id || $value -> user_to == Auth::user()->id;
      });


      $post = DB::table('post')->get();
      if ($filter_friend->isNotEmpty()){
          $filtered = $post->filter(function ($value) use ($filter_friend){
          foreach($filter_friend as $fr){
              if(($value->id_user == $fr->user_to || $value->id_user == $fr->user_from || $value->ispublic == 1 ) && $value->post_state == 0 && $value->id_groups == 0)
              return true;
              
          }});
      }else {
          $post = DB::table('post')->where('ispublic',1)->where('id_user','!=',Auth::user()->id)->get();
          $post1 = DB::table('post')->where('id_user',Auth::user()->id)->get();
          $post = $post->concat($post1);
          $post->all();

          $filtered = $post->filter(function ($value){
              if($value->post_state == 0)
                  return true;        
          });
      }

      return $filtered->reverse();
    } 

    public static function showUserPosts($user_id){
      $post = DB::table('post')->where('id_user',$user_id)->where('post_state', 0)->where('id_groups', 0)->get();
      return $post->reverse();
  }

  public static function postpage($id_post){
    $post = DB::table('post')->where('id',$id_post)->first();
    $comments = DB::table('comment')->where('id_post', $id_post)->where('comment_state', 0)->get();

    return view('pages.card_coments', ['post' => $post, 'comments' => $comments]);
  }

  public static function editpost($id_post){
    $post = DB::table('post')->where('id',$id_post)->first();
    return view('pages.card_edit', ['post' => $post]);
  }

  public static function editgroupdescription($id_group){
    $group = DB::table('groups')->where('id_groups',$id_group)->first();
    return view('pages.groups_edit', ['group' => $group]);
  }

  public static function groupPost($id_group){
    $post = DB::table('post')->where('id_groups',$id_group)->where('post_state', 0)->get();
    return $post->reverse();
  }

  public static function creategroup(Request $request, $id_group){
      $post = new post();
      $maxId = DB::table('post')->max('id'); 
      $post->id=$maxId +1;
      $post->id_user = Auth::user()->id;
      $post->content = $request->input('content');
      $post->post_state = 0;
      $post->post_date = date("Y/m/d");
      $post->ispublic = 1;
      $post->id_groups = $id_group;
      $post->save();
      return redirect()->back();
  }
}