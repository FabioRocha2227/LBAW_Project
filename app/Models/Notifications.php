<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Notifications extends Model{
    public $timestamps  = false;
    protected $table = 'notifications';

    protected $fillable = [
        'id_notifications', 'notification_type', 'notification_date', 'user_to', 'user_from',
    ];
}
