<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ReactPost extends Model{
    public $timestamps  = false;
    protected $table = 'react_post';

    protected $fillable = [
        'user_id', 'react_post_date', 'id_post',
    ];
}