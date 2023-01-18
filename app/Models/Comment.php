<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Comment extends Model{
    public $timestamps  = false;
    protected $table = 'comment';

    protected $fillable = [
        'comment_state', 'content', 'comment_date', 'id_user', 'id_post',
    ];
}