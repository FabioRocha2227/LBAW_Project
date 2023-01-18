<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReactPostController;
use App\Http\Controllers\ReactCommentController;
?>
@if(!UserController::isBanned(Auth::user()->id))
<script type="text/javascript">
window.location = '/banned'; //here double curly bracket
</script>
@endif
@extends('layouts.app')

@section('content')
<!-- Highlighted tweet -->
<div class="card mb-3">
    <div class="card-body">

        <li class="media mb-3 timeline-tweet">
            <img src="https://images.unsplash.com/photo-1633332755192-727a05c4013d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8dXNlcnxlbnwwfHwwfHw%3D&w=1000&q=80"
                class="mr-3 rounded-circle" width="50" alt="avatar">
            <div class="media-body">
                <h5 class="mt-0 mb-1 font-weight-bold">{{UserController::requestUsername($post->id_user)}}</h5>
            </div>
        </li>


        <p class="card-text">{{$post->content}}</p>
        <footer class="blockquote-footer"> Tweeted on <cite title="Source Title">{{$post->post_date}}</cite>
        </footer>

        <div class="d-flex align-items-center mt-3">


            @if ($post -> id_user != Auth::user()->id && UserController::react_post(Auth::user()->id ,$post->id))
            <form method="GET" id="likeForm"
                action="{{route('react_post', ['id_user' => Auth::user()->id, 'id_post' => $post->id, 'user_to' => $post->id_user])}}">
                <button id="likeButton" type="submit" class="btn btn-outline-primary mr-2">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-heart" fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />
                    </svg>
                    {{ReactPostController::countLikes($post->id)}}
                </button>
            </form>
            @elseif(!UserController::react_post(Auth::user()->id ,$post->id))
            <form method="GET" id="likeForm"
                action="{{route('react_post_delete', ['id_user' => Auth::user()->id, 'id_post' => $post->id, 'user_to' => $post->id_user])}}">
                <button id="unlikeButton" type="submit" class="btn btn-outline-danger mr-2">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-heart" fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />
                    </svg>
                    {{ReactPostController::countLikes($post->id)}}
                </button>
            </form>
            @else
            <button id="unlikeButton" type="submit" class="btn btn-outline-danger mr-2">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-heart" fill="currentColor"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />
                </svg>
                {{ReactPostController::countLikes($post->id)}}
            </button>
            @endif
        </div>



    </div>
</div>


<!-- Add comment form -->
<form action="{{ route('postUpdate', ['id' => $post->id]) }}" method="POST" class="mt-4">
    @csrf
    @method('POST')
    <div class="form-group">
        <label for="commentInput">Edit the text</label>
        <textarea class="form-control" id="done" name="done" rows="3" placeholder="Write here to edit..."></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
</div>
</div>

@endsection