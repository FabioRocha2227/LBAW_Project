<?php
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

function insertPost(string $content){
    
    DB::insert('insert into post(id_post,post_state,content,post_date,ispublic,id_groups) values(?,?,?,?,?,?)', [Auth::user()->id,0,$content,]);
}

