<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;


class ProfileController extends Controller{

    public function search(Request $request){
        $user = DB::table('users')->where('username', $request->username)->first();
        $id = UserController::requestId($request->username);

        $post = DB::table('post')->where('id_user',$id)->where('post_state', 0)->get();
        if ($user != null){
            return view('pages.profile',['user' => $user, 'post' => $post->reverse()]);
        }else{
            return redirect('/');
        }
      
    }

    public static function view($id_user){
        $user = DB::table('users')->where('id',$id_user)->first();
        return view('pages.profile', ['user' => $user]);
    }

}

