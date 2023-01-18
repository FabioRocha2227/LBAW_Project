<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReactPostController;
?>

@if(!UserController::isBanned(Auth::user()->id))
<script type="text/javascript">
window.location = '/banned'; //here double curly bracket
</script>
@endif

@if(!UserController::isActive(Auth::user()->id))
<script type="text/javascript">
window.location = '/deleted'; //here double curly bracket
</script>
@endif

@extends('layouts.app')


@section('content')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
    integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

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

.card {
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
}

#tweetText {
    background-color: #fafafa;
}

.form-control-file {
    background-color: transparent;
    border: none;
    outline: none;
}
</style>





<div class="card mb-3 timeline-tweet" style="border: none;">
    <div class="card-body">
        <div class="media">
            <img src="https://images.unsplash.com/photo-1633332755192-727a05c4013d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8dXNlcnxlbnwwfHwwfHw%3D&w=1000&q=80"
                class="mr-3 rounded-circle" width="50" alt="avatar">
            <div class="media-body">
                <form method="POST" action="{{ route('postInsert') }}">
                    @csrf
                    @method('POST')
                    <div class="form-group mt-3 mb-3">
                        <textarea class="form-control" name="content" id="tweetText" rows="3"
                            placeholder="What's happening?"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <label for="tweetImage" class="btn btn-outline-secondary mr-3">
                                <i class="fas fa-image"></i> Add Image
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 offset-6">
                            <button type="submit" class="btn btn-primary" style="float: right;">Tweet</button>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>


@foreach($posts = PostController::showPosts(Auth::user()->id) as $key => $post)
<ol class="list-unstyled">
    <li class="media mb-3 timeline-tweet">
        <img src="https://images.unsplash.com/photo-1633332755192-727a05c4013d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8dXNlcnxlbnwwfHwwfHw%3D&w=1000&q=80"
            class="mr-3 rounded-circle" width="50" alt="avatar">
        <div class="media-body">
            <a href="{{route('profilepage', ['id_user' => $post -> id_user])}}" class="username_post">
                <h5 class="mt-0 mb-1 font-weight-bold">{{UserController::requestUsername($post->id_user)}}</h5>
            </a>
            {{$post->content}}
            <div class="d-flex justify-content-between align-items-center mt-2">
                <small class="text-muted">{{$post->post_date}}</small>

                <div class="d-flex align-items-center mt-3">

                    <!-- Like area -->

                    <form method="GET" action="{{ route('like', ['id_post' => $post->id]) }}">
                        @csrf  
                    <button id="unlikeButton" type="submit" class="btn btn-outline-danger mr-2">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-heart" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />
                            </svg>
                            {{ReactPostController::countLikes($post->id)}}
                        </button>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>





                    <form method="GET" action="{{ route('postpage', ['id_post' => $post->id]) }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-dark mx-1">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chat-dots"
                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.682.716-2.499 1.862z" />
                                <path
                                    d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                            </svg>
                        </button>
                    </form>
                    @if($post->id_user == Auth::user()->id)
                    <form action="{{ route('editpost', ['id_post' => $post->id]) }}" method="GET">
                        @csrf

                        <button type="submit" class="btn btn-outline-warning mx-1">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z" />
                                <path fill-rule="evenodd"
                                    d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z" />
                            </svg>
                    </form>
                    <form action="{{ route('postDelete', ['id' => $post->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger mx-1" type="submit" data-toggle="tooltip"
                            title="Delete">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                <path fill-rule="evenodd"
                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                            </svg>

                        </button>

                    </form>
                    @endif
                </div>

            </div>
    </li>
</ol>


@endforeach


@endsection