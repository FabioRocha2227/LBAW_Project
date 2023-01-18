<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Models\Group;
use App\Models\GroupUser;

class GroupController extends Controller{

    public static function create(Request $request){
        $group = new Group();
        $maxId = DB::table('groups')->max('id_groups');
        $group->id_groups = $maxId +1;
        $group->group_description = $request->input('name');
        $group->group_name = 'none';
        $group->group_state = 0;
        $group->group_date = date("Y/m/d");
        DB::insert('insert into groups (id_groups, group_description, group_name,group_state, group_date, id_owner) values (?,?, ?,?, ?,?)', [$group->id_groups,$group->group_description, $group->group_name,$group->group_state,$group->group_date, Auth::user()->id]);
        $max = DB::table('group_user')->max('id');
        $max = $max +1;
        DB::insert('insert into group_user (id, id_group, id_user) values (?,?,?)', [$max ,$group->id_groups,Auth::user()->id]);
        return view('pages.groups'); 
    }   

    public function updategroupdescription(Request $request, $id_group)
    {
        DB::table('groups')->where('id_groups',$id_group )->update(['group_name' =>  $request->done]);
        
        return view('pages.groups');
    }

    public static function isNotInGroup($id_group, $id_user){
        $members = DB::table('group_user')->where('id_group', $id_group)->where('id_user', $id_user)->get();
        return $members->isEmpty(); 
    }

    public static function delete($id_group){
        DB::table('groups')->where('id_groups',$id_group)->update(array('group_state' => 1));
        if(Auth::user()->id == 1){
            return view('pages.administration');
        }else{
            return view('pages.groups');
        }
        
    }
    public static function unban($id_group){
        DB::table('groups')->where('id_groups',$id_group)->update(array('group_state' => 0));
        return view('pages.administration');
    }

    public static function remove($id_group, $id_user){
        $members = DB::table('group_user')->where('id_group', $id_group)->where('id_user', $id_user)->delete();
        return redirect()->back();
    }

    public static function add($id_group, $id_user){
        $gu = new GroupUser();
        $max = DB::table('group_user')->max('id');
        $gu->id = $max +1;
        $gu->id_group = $id_group;
        $gu->id_user = $id_user;
        DB::insert('insert into group_user (id, id_group, id_user) values (?,?,?)', [$gu->id,$gu->id_group,$gu->id_user = $id_user]);
        return view('pages.viewadd',['group'=>$id_group]);
    }

    public static function viewAdd($id_group){
        return view('pages.viewadd', ['group'=>$id_group]);
    }


    public static function showGroups($user_id){
        $group_user = DB::table('group_user')->where('id_user',$user_id)->get();
        $groups = DB::table('groups')->where('id_groups','!=', 0)->where('group_state', 0)->get();
        
        $filter_groups = $groups->filter(function($value) use ($group_user){
            foreach($group_user as $gu){
                if($value->id_groups == $gu->id_group){
                    return true;
                }
            }
        });
        return $filter_groups;
    }

    public static function members($id_group){
        $members = DB::table('group_user')->where('id_group', $id_group)->get();
        
        return count($members);
    }

    public static function getMembers($id_group){
        $members = DB::table('group_user')->where('id_group', $id_group)->get();
        
        return $members;
    }

    public static function group_page($id_group){
        $group = DB::table('groups')->where('id_groups',$id_group)->first();
        return view('pages.group_page',['group' => $group]);
    }

    public static function leave($id_group){
        $friend = DB::table('group_user')->where('id_group', $id_group)->where('id_user', Auth::user()->id)->delete();
        return view('pages.groups');
    }

    public static function posts($id_group){
        $post = DB::table('post')->where('id_groups',$id_group)->where('post_state', 0)->get();
        return count($post);
    }

    public static function view(){
        return view('pages.create_group');
    }
}