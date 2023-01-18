<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ReactPostController;
?>
@if(!UserController::isBanned(Auth::user()->id))
<script type="text/javascript">
    window.location = '/banned';//here double curly bracket
</script>
@endif
@extends('layouts.app')
@section('content')
<section class="d-inline-block  justify-content-center">
<div class="container-fluid">
    <div class="row">
        <div class="col">     
        <h2>Friends List</h2> 
        @foreach ($friends = UserController::requestFriends(Auth::user()->id) as $key => $friend)
        
        <div id="amigos" class="d-flex flex-row justify-content-between">
                @if(Auth::user()->id == $friend->user_from && GroupController::isNotInGroup($group, $friend-> user_to))
                <h5> {{UserController::requestUsername($friend-> user_to)}}</h5>
                <form method="POST" action="{{ route('addmembergroup', ['id_group'=> $group, 'id_user' => $friend-> user_to]) }}">
                @csrf
                @method('POST')
                <button type="submit" class="btn btn-primary ">Add member</button> 
                </form>
               @elseif(Auth::user()->id == $friend->user_to && GroupController::isNotInGroup($group, $friend-> user_from))
                <h5> {{UserController::requestUsername($friend-> user_from)}}</h5>
                <form method="POST" action="{{ route('addmembergroup', ['id_group'=> $group, 'id_user' => $friend-> user_from]) }}">
                @csrf
                @method('POST')
                <button type="submit" class="btn btn-primary ">Add member</button> 
                </form>
                @endif
        </div>
</br>   
        @endforeach
        </div>
        </div>
    </div>   
</div>
</section>

@endsection
