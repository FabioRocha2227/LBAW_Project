<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ReactComment extends Model{
    public $timestamps  = false;
    protected $table = 'react_comment';

    protected $fillable = [
        'user_id', 'react_comment_date', 'id_comment',
    ];
}