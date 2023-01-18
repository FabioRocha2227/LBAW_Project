<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Group extends Model{
    public $timestamps  = false;
    protected $table = 'groups';
    protected $fillable = [
        'group_description', 'group_state', 'group_name', 'group_date','group_name'
    ];
}