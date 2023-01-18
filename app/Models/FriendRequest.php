<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class FriendRequest extends Model{
    public $timestamps  = false;
    protected $table = 'friend_request';

    protected $fillable = [
        'user_from', 'user_to', 'accepted', 'requested', 'refused',
    ];
}