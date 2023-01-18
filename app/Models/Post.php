<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Post extends Model{
    public $timestamps  = false;
    protected $table = 'post';

    protected $fillable = [
        'id_post', 'id_user', 'post_state','content','post_date','id_groups',
    ];


    /**
   * The user this post belongs to.
   */
  public function user() {
    return $this->belongsTo('App\Models\User');
  }


}
