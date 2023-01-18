<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
?>
@if(!UserController::isBanned(Auth::user()->id))
<script type="text/javascript">
window.location = '/banned'; //here double curly bracket
</script>
@endif
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
    integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

@extends('layouts.app')

@section('content')
<!-- Main content -->
<div class="container mt-5">
    <div class="row">
        <!-- Profile picture -->
        <div class="col-md-4">
            <img src="https://images.unsplash.com/photo-1633332755192-727a05c4013d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8dXNlcnxlbnwwfHwwfHw%3D&w=1000&q=80"
                alt="Profile picture" class="img-fluid rounded-circle">
        </div>

        <!-- Profile details -->
        <div class="col-md-8">
            <h1 class="h2 mb-3">{{UserController::requestUsername($user->id)}}</h1>
            <p class="lead mb-4">A brief description about yourself</p>
            <ul class="list-inline mb-4">
                <li class="list-inline-item mr-3">
                    <strong>Friends:</strong> {{UserController::friends_count($user->id)}}
                </li>
            </ul>
            @if(Auth::user()->id !=$user->id)
            @if (UserController::requestUsername(Auth::user()->id) != $user->username &&
            UserController::friendship($user->id) && UserController::fr_sent($user->id))
            <form action="{{ route('friend_request', ['user_from' => Auth::user()->id, 'user_to' => $user->id]) }}"
                method="POST">
                @csrf
                @method('POST')
                <button type="submit" class="btn btn-primary mr-2">ADD FRIEND</button>
            </form>
            @elseif (UserController::fr_request($user->id))
            <button type="button" class="btn btn-info mr-2">FR SENT</button>
            @else
            <form action="{{ route('unfriend', ['user_from' => Auth::user()->id, 'user_to' => $user->id]) }}"
                method="DELETE">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger mr-2">UNFRIEND</button>
            </form>
            @endif
            @else
            <form id="update-form">
                @csrf
                @method('POST')
                <div class="custom-control custom-switch">
                    <label class="switch">
                        @if(Auth::user()->ispublic == 1)
                        <input type="checkbox" name="value" value="1" class="custom-control-input" id="customSwitches"
                            checked>
                        @else
                        <input type="checkbox" name="value" value="1" class="custom-control-input" id="customSwitches">
                        @endif
                        <label class="custom-control-label" for="customSwitches">Public Profile</label>
                    </label>
                </div>
            </form>

            <form method="POST"  action="{{ route('userDelete', ['id' =>  $user->id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger mx-1" type="submit" data-toggle="tooltip"
                    title="Delete">
                    Delete Account
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                        <path fill-rule="evenodd"
                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                    </svg>

                </button>

            </form>
            <script>
            $('.switch').click(function() {
                var formData = $('#update-form').serialize();
                $.ajax({
                    url: "{{ route('ispublic') }}",
                    type: 'POST',
                    data: formData,
                    success: function(data) {

                    }
                });
            });
            </script>
            @endif
        </div>
    </div>

    <!-- Tweets -->
    <div class="row mt-5">
        <div class="col-md-4">
            <h2 class="h4 mb-3">Tweets</h2>
        </div>
        <div class="col-md-8">
            @foreach($posts = PostController::showUserPosts($user->id) as $key => $post)
            <div class="card mb-3">
                <div class="card-body">
                    <p class="card-text">{{$post->content}}</p>
                    <footer class="blockquote-footer">
                        Tweeted on <cite title="Source Title">{{$post->post_date}}</cite>
                    </footer>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
  // Get the footer element
  var footer = document.querySelector('.footer');
  
  // Add the fixed-bottom class to the footer element
  footer.classList.add('fixed-bottom');
});
  </script>
@endsection