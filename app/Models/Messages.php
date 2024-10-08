<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Messages extends Model{
    public $timestamps  = false;
    protected $table = 'messages';

    protected $fillable = [
        'id', 'content', 'sender', 'msg_date',
    ];
}
