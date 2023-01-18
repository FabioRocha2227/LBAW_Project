<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class GroupUser extends Model{
    public $timestamps  = false;
    protected $table = 'group_user';
    protected $fillable = [
        'id', 'id_group', 'id_user',
    ];
}