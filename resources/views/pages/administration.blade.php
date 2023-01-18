<?php
use App\Http\Controllers\UserController;
?>
@extends('layouts.app')
@section('content')
<style>
#animated-text {
    display: inline-block;

    transition: all 0.1s ease-in-out;
}

#animated-text.visible {
    visibility: visible;
}
</style>
<div class="container mt-5">
    <!-- Banner -->
    <div class="jumbotron jumbotron-fluid bg-white text-white">
        <div class="container" id="animated-text-container">
            <h1 id="animated-text" class="display-4"></h1>
        </div>
    </div>

    <!-- Tabbed interface -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="users-tab" data-toggle="tab" href="#users" role="tab" aria-controls="users"
                aria-selected="true">Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="groups-tab" data-toggle="tab" href="#groups" role="tab" aria-controls="groups"
                aria-selected="false">Groups</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="posts-tab" data-toggle="tab" href="#posts" role="tab" aria-controls="posts"
                aria-selected="false">Posts</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="comments-tab" data-toggle="tab" href="#comments" role="tab" aria-controls="comments"
                aria-selected="false">Comments</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <!-- Users -->
        <div class="tab-pane fade show active" id="users" role="tabpanel" aria-labelledby="users-tab">
            <table class="table mt-4 table-responsive-sm-x table-responsive-md-y">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Avatar</th>
                        <th scope="col">Visibility</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>John Doe</td>
                        <td>johndoe</td>
                        <td>johndoe@example.com</td>
                        <td>
                            <img src="avatar.jpg" alt="John Doe's avatar" class="rounded-circle" width="50">
                        </td>
                        <td>Visible</td>
                        <td>
                            <div class="custom-control custom-switch mr-3">
                                <input type="checkbox" class="custom-control-input" id="admin-switch-1" checked>
                                <label class="custom-control-label" for="admin-switch-1">Admin</label>
                            </div>
                            <div class="custom-control custom-switch mr-3">
                                <input type="checkbox" class="custom-control-input" id="block-switch-1" >
                                <label class="custom-control-label" for="block-switch-1">Blocked</label>
                            </div>
                            <button class="btn btn-danger delete-profile" data-user-id="1">Delete</button>
                        </td>
                    </tr>
                    @foreach($users = UserController::allUsers() as $key => $user)
                    <tr>
                        <td>{{$user->full_name}}</td>
                            <td>{{$user->username}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                <img src="avatar.jpg" alt="{{UserController::requestUsername($user->id)}} avatar" class="rounded-circle" width="50">
                            </td>
                            <td>Visible</td>
                            <td>
                                @if(!UserController::isBanned($user->id))
                                <form method="POST" action="{{ route('unban', ['id_user' => $user->id]) }}" >
                                @csrf
                                @method('POST')
                                <button class="btn btn-success delete-profile" data-user-id="1">UNBAN</button>
                                </form>
                                @else
                                <form method="POST" action="{{ route('ban', ['id_user' => $user->id]) }}" >
                                @csrf
                                @method('POST')
                                <button class="btn btn-danger delete-profile" data-user-id="1">BAN</button>
                                </form>
                                @endif
                            </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Groups -->
        <div class="tab-pane fade" id="groups" role="tabpanel" aria-labelledby="groups-tab">
            <table class="table mt-4">
                <thead>
                    <tr>
                        <th scope="col">Group name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($groups = UserController::allGroups() as $key => $group)
                    <tr>
                    <td>{{$group->group_description}}</td>
                    @if($group->group_state == 0)
                        <td>Active</td>
                        <td>
                        <form method="POST" action="{{ route('groupdelete', ['id_group' => $group->id_groups]) }}" >
                            @csrf
                            @method('POST')
                            <button type="submit" onclick="myFunction()" class="btn btn-danger">BAN</button>
                        </form>
                        </td> 
                        @else
                        <td>Deleted</td>
                        <td>
                        <form method="POST" action="{{ route('groupunban', ['id_group' => $group->id_groups]) }}" >
                            @csrf
                            @method('POST')
                            <button type="submit" onclick="myFunction()" class="btn btn-success">UNBAN</button>
                        </form>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade" id="posts" role="tabpanel" aria-labelledby="posts-tab">
            <table class="table mt-4">
                <thead>
                    <tr>
                        <th scope="col">User</th>
                        <th scope="col">Post content</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody> 
                    @foreach($posts = UserController::allPosts() as $key => $post)
                    <tr>
                        <td>
                            {{UserController::requestUsername($post->id_user)}}
                        </td>
                        <td>
                            {{$post->content}}
                        </td>
                        <td>
                            @if($post->post_state == 0)
                            Active
                            @else
                            Deleted
                            @endif
                        </td>
                        <td>
                        @if($post->post_state == 0)
                        <form method="POST" action="{{ route('postDelete', ['id' => $post->id]) }}" >
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="myFunction()" class="btn btn-danger">DISABLE</button>
                        </form>
                        @else
                        <form method="POST" action="{{ route('postAdmin', ['id' => $post->id]) }}" >
                            @csrf
                            @method('POST')
                            <button type="submit" onclick="myFunction()" class="btn btn-success">ENABLE</button>
                        </form>
                        @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="comments" role="tabpanel" aria-labelledby="comments-tab">
            <table class="table mt-4">
                <thead>
                    <tr>
                        <th scope="col">User</th>
                        <th scope="col">Comment content</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($comments = UserController::allComments() as $key => $comment)
                    <tr>
                        <td>
                            {{UserController::requestUsername($comment->id_user)}}
                        </td>
                        <td>
                            {{$comment->content}}
                        </td>
                        <td>
                            @if($comment->comment_state == 0)
                            Active
                            @else
                            Deleted
                            @endif
                        </td>
                        <td>
                            @if($comment->comment_state == 0)
                            <form action="{{ route('commentDelete', ['id' => $comment->id_comment]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">DISABLE</button>
                            </form>
                            @else
                            <form method="POST" action="{{ route('commentAdmin', ['id' => $comment->id_comment]) }}" >
                            @csrf
                            @method('POST')
                            <button type="submit" onclick="myFunction()" class="btn btn-success">ENABLE</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                </tbody>
                @endforeach 
            </table>
        </div>
        <script>
        $('#myTab a').on('click', function(e) {
            e.preventDefault()
            $(this).tab('show')
        })

        const text = 'Welcome back, {{ Auth::user()->username }} !';
        let index = 0;

        const interval = setInterval(() => {
            document.querySelector('#animated-text').innerHTML += text[index];
            index++;

            if (index === text.length) {
                clearInterval(interval);
            }
        }, 100);
        </script>





        @endsection