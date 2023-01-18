<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Comment;
use App\Models\Notifications;

class NotificationsController extends Controller{
    public static function showNotifications(){
        $notifications = DB::table('notifications')->where('user_to', Auth::user()->id)->get();
        return $notifications->reverse();
    }
}