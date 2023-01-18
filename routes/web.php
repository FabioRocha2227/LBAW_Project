<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ReactPostController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use App\ReactComment;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Home
Route::get('/', 'Auth\LoginController@home');

// Cards
Route::get('cards', 'CardController@list');
Route::get('cards/{id}', 'CardController@show');

// Flow
Route::get('app', 'FlowController@app');
Route::get('messages', 'FlowController@messages');
Route::get('notifications', 'FlowController@notifications');
Route::get('profile', 'FlowController@profile');
Route::get('settings', 'FlowController@settings');

//Notifications View
Route::get('notifications', function(){
    $fr = DB::table('friend_request')->where('user_to', Auth::user()->id)->where('requested', 1)->get();
    $react = DB::table('react_post')->where('user_to', Auth::user()->id)->get();
    return view('pages.notifications',['friend_request' => $fr->reverse(), 'react' => $react->reverse()]);
});

//Friend request view
/*Route::get('fr_view',function(){
    
    $fr = DB::table('friend_request')->where('user_to', Auth::user()->id)->where('requested', 1)->get();
    return view('pages.notifications',['friend_request' => $fr->reverse()]);
});
*/

Route::post('ispublic', 'UserController@public')->name('ispublic');

//React Post
Route::post('react_post/{id_user}{id_post}{user_to}', 'ReactPostController@add')->name('react_post');
Route::post('react_post_delete/{id_user}{id_post}{user_to}', 'ReactPostController@delete')->name('react_post_delete');


//Friend Request
Route::post('friend_request/{user_from}{user_to}', 'FriendRequestController@add')->name('friend_request');
Route::post('accept_request/{id}','FriendRequestController@accept')->name('accept_request');
Route::post('reject_request/{id}','FriendRequestController@reject')->name('reject_request');

//Friend
Route::get('unfriend/{user_from}{user_to}', 'FriendRequestController@delete')->name('unfriend');

Route::get('cards', function(){

    $friend = DB::table('friend')->get();
    $filter_friend = $friend->filter(function($value,$key){
        return $value -> user_from == Auth::user()->id || $value -> user_to == Auth::user()->id;
    });


    $post = DB::table('post')->get();
    if ($filter_friend->isNotEmpty()){
        $filtered = $post->filter(function ($value) use ($filter_friend){
        foreach($filter_friend as $fr){
            if(($value->id_user == $fr->user_to || $value->id_user == $fr->user_from || $value->ispublic == 1) && $value->post_state == 0)
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
    return view('pages.cards',['post' => $filtered->reverse()]);  
});

Route::get('profileShow1/{username}{id_user}', 'ProfileController@view')->name('profileShow1');
Route::post('profileShow', 'ProfileController@search')->name('profileShow');
Route::post('postInsert', 'PostController@create')->name('postInsert');
Route::post('postUpdate/{id}','PostController@update')->name('postUpdate');
Route::post('postAdmin/{id}', 'PostController@adminPost')->name('postAdmin');
Route::post('groupInsert/{id_group}', 'PostController@creategroup')->name('groupInsert');

Route::get('creategroup', 'GroupController@view')->name('creategroup');
Route::post('register_group', 'GroupController@create')->name('register_group');


Route::get('profilepage/{id_user}', 'ProfileController@view')->name('profilepage');

Route::get('admin', 'UserController@adminView')->name('admin');
Route::post('unban/{id_user}', 'UserController@unban')->name('unban');
Route::post('ban/{id_user}', 'UserController@ban')->name('ban');

//Comment
Route::post('commentInsert/{id_post}','CommentController@create')->name('commentInsert');
Route::delete('commentDelete/{id}', 'CommentController@delete')->name('commentDelete');
Route::post('commentAdmin/{id}', 'CommentController@admin')->name('commentAdmin');
Route::post('commentUpdate/{id}{id_post}','CommentController@update')->name('commentUpdate');


// API
Route::put('api/cards', 'CardController@create');
Route::put('api/post', 'PostController@create');
Route::get('username/{id}', 'FlowController@requestUsername')->name('username');
Route::delete('postDelete/{id}', 'PostController@delete')->name('postDelete');
Route::delete('api/cards/{card_id}', 'CardController@delete');
Route::put('api/cards/{card_id}/', 'ItemController@create');
Route::post('api/item/{id}', 'ItemController@update');
Route::delete('api/item/{id}', 'ItemController@delete');


Route::get('banned', function(){

    return view('pages.banned'); 
});
// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');

Route::post('guest', 'Auth\LoginController@guest');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');



Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

//Groups view
Route::get('groups', function(){
    $groups = DB::table('groups')->get();
    return view('pages.groups',['groups' => $groups->reverse()]); 
});
Route::get('faq', function(){
  
    return view('pages.faq'); 
});

//Groups Page view
Route::get('groupspage/{id_group}', 'GroupController@group_page')->name('groupspage');
Route::get('groupleave/{id_group}', 'GroupController@leave')->name('groupleave');
Route::post('groupdelete/{id_group}', 'GroupController@delete')->name('groupdelete');
Route::post('groupunban/{id_group}', 'GroupController@unban')->name('groupunban');
Route::get('groupremove/{id_group}{id_user}', 'GroupController@remove')->name('groupremove');
Route::get('addmembers/{id_group}', 'GroupController@viewAdd')->name('addmembers');
Route::post('addmembergroup/{id_group}{id_user}', 'GroupController@add')->name('addmembergroup');

Route::get('tweet', function(){
    $groups = DB::table('groups')->get();
    return view('pages.card_coments',['groups' => $groups->reverse()]); 
});


Route::get('postpage/{id_post}', 'PostController@postpage')->name('postpage');

Route::get('editpost/{id_post}', 'PostController@editpost')->name('editpost');
Route::get('editgroupdescription/{id_group}', 'PostController@editgroupdescription')->name('editgroupdescription');
Route::post('groupdescriptionUpdate/{id_group}','GroupController@updategroupdescription')->name('groupdescriptionUpdate');


//FTS

Route::get('/search', function(Request $request) {
    $query = $request->query('query');
  
    $results = DB::table('users')
                  ->whereRaw("search @@ to_tsquery(?)", $query)
                  ->get();
  
    return view('pages.profiles', ['results' => $results]);
  });
  


  Route::get('administration', function(){
    return view('pages.administration'); 
});

Route::get('like/{id_post}', 'PostController@like')->name('like');


Route::get('likecoment/{id_comment}', 'ReactCommentController@like')->name('likecoment');
  

//Password recovery
Route::get('password/reset', 'PasswordResetController@create');

Route::post('password/email', 'PasswordResetController@store');

Route::get('password/reset/{token}', 'PasswordResetController@edit');

Route::post('password/reset', 'PasswordResetController@update');


//user delete 


Route::delete('userDelete/{id}', 'UserController@deleteAccount')->name('userDelete');

Route::get('/deleted', function(){
    return view('pages.deleted'); 
});