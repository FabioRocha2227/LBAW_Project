<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class UserController extends Controller{
    public static function unban($id_user){
        DB::table('banned')->where('id_user', $id_user)->delete();
        return redirect('administration');
    } 

    public static function ban($id_user){
        $id =  DB::table('banned')->max('id');
        $maxId = $id +1; 
        DB::insert('insert into banned (id,id_user) values (?, ?)', [$maxId, $id_user]);
        return redirect('administration');
    }
    public static function public(Request $request){
        $value = $request->input('value');
        if($value == "1"){
            DB::table('post')->where('id_user', Auth::user()->id)->update(['ispublic' => 1]);
            DB::table('users')->where('id',Auth::user()->id)->update(['ispublic'=>1]);
        }else{
            DB::table('post')->where('id_user', Auth::user()->id)->update(['ispublic' => 0]);
            DB::table('users')->where('id',Auth::user()->id)->update(['ispublic'=>0]);
        }
        
        return response()->json([
            'success' => true,
          ]);
    }

    public static function isBanned($id_user){
        $bann = DB::table('banned')->where('id_user',$id_user)->first();
        if($bann == NULL){
            return true;
        }else{
            return false;
        }
    }
    
    public static function isActive($id_user){
        $bann = DB::table('users')->where('id',$id_user)->first();
        if($bann->active == 1){

            return true;
        }else{
         
                return false;
          
        }
    }

    public static function ispublic(){
        if(Auth::user()->ispublic == 1){
            return true;
        }else{
            return false;
        }
    }
    public static function adminView(){
        return view('pages.administration');
    }
    public static function allUsers(){
        $users = DB::table('users')->where('isadmin' , 0)->get();
        return $users;
    }
    public static function allGroups(){
        $groups = DB::table('groups')->where('id_groups', '!=', 0)->get();
        return $groups;
    }
    public static function allPosts(){
        $posts = DB::table('post')->get();
        return $posts->reverse();
    }
    public static function allComments(){
        $comments = DB::table('comment')->get();
        return $comments->reverse();
    }

    public static function requestUsername($id){
        $user = DB::table('users')->where('id', $id)->value('username');
        return $user;
    }
    public static function requestId($username){
        $user = DB::table('users')->where('username', $username)->value('id');
        return $user;
    }

    public static function requestAdmin($id){
        $user = DB::table('users')->where('id', $id)->value('isadmin');
        return $user;
    }

    public static function fr_notification(){
        $fr = DB::table('friend_request')->where('user_to', Auth::user()->id)->where('requested', 1)->get();
        return $fr->reverse();
    }

    public static function react_notification(){
        $rp = DB::table('react_post')->where('user_to', Auth::user()->id)->get();
        return $rp->reverse();
    }

    public static function friendship($id_user){
        $friend = DB::table('friend')->get();
        $filter_friend = $friend->filter(function($value,$key){
            return $value -> user_from == Auth::user()->id || $value -> user_to == Auth::user()->id;
        });

        $friendship = $filter_friend->filter(function($value) use ($id_user){
            return $value -> user_from == $id_user || $value -> user_to == $id_user;
        });
        
        return $friendship->isEmpty();
    
    }

    public static function fr_sent($id_user){
        $friend = DB::table('friend_request')->where('requested',1)->get();
        $filter_friend = $friend->filter(function($value,$key){
            return $value -> user_from == Auth::user()->id || $value -> user_to == Auth::user()->id;
        });

        $last = $filter_friend->filter(function($value) use ($id_user){
            return $value->user_from == $id_user || $value -> user_to == $id_user;
        });

        return $last->isEmpty();
    }

    public static function fr_request($id_user){
        $friend = DB::table('friend_request')->where('requested',1)->get();
        $filter_friend = $friend->filter(function($value,$key){
            return $value -> user_from == Auth::user()->id || $value -> user_to == Auth::user()->id;
        });

        $last = $filter_friend->filter(function($value) use ($id_user){
            return $value->user_from == $id_user || $value -> user_to == $id_user;
        });

        return $last->isNotEmpty();
    }

    public static function friends_count($id){
        $friend = DB::table('friend')->get();
        $filter_friend = $friend->filter(function($value) use ($id){
            return $value -> user_from == $id || $value -> user_to == $id;
        });
        
        return count($filter_friend); 
    }

    public static function react_post($id_user , $id_post){
        $rp = DB::table('react_post')->where('id_post' , $id_post)->where('user_id', $id_user)->get();
        return $rp -> isEmpty();
    }

    public static function react_comment($id_user , $id_comment){
        $rp = DB::table('react_comment')->where('id_comment' , $id_comment)->where('user_id', $id_user)->get();
        return $rp -> isEmpty();
    }

    public static function requestFriends($id_user){
        $friend = DB::table('friend')->get();
        $filter_friend = $friend->filter(function($value,$key) use ($id_user){
            return $value -> user_from == $id_user || $value -> user_to == $id_user;
        });
        return $filter_friend;
    }

    public static function deleteAccount($id){
    
        DB::table('users')->where('id', $id)->update(['active' => 0]);
        return redirect('/logout');
    }

}
