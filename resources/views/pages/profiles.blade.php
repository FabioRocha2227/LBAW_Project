<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
?>
@if(!UserController::isBanned(Auth::user()->id))
<script type="text/javascript">
    window.location = '/banned';//here double curly bracket
</script>
@endif
@extends('layouts.app')

@section('content')
<style>
.timeline-tweet {
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #ffffff;
    padding: 20px;
}

.timeline-tweet .tweet-image {
    float: left;
    margin-right: 20px;
    max-width: 60%;
    max-height: 60%;
    overflow: auto;
}

.timeline-tweet .avatar-image {
    border-radius: 50%;
    width: 50px;
    height: 50px;
}

.timeline-footer {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: #f8f9fa;
    text-align: center;
    padding: 20px;
}

.username_post:hover {
    text-decoration: none;
}
</style>

@foreach ($results as $result)
<ol class="list-unstyled">
    <li class="media mb-3 timeline-tweet">
        <img src="https://images.unsplash.com/photo-1633332755192-727a05c4013d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8dXNlcnxlbnwwfHwwfHw%3D&w=1000&q=80"
            class="mr-3 rounded-circle" width="50" alt="avatar">

        <a href="{{route('profilepage', ['id_user' =>  UserController::requestId($result->username)])}}"
            class="username_post">
            <h5 class="mt-0 mb-1 font-weight-bold"> {{ $result->username }}</h5>
        </a>


</ol>
@endforeach
@endsection