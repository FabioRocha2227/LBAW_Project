<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Friend extends Model{
    public $timestamps  = false;
    protected $table = 'friend';

    protected $fillable = [
        'user_from','user_to',
    ];

}