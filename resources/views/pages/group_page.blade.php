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

<div class="container">
    <div class="row mb-3">
        <div class="col-md-12 text-center">
            <img src="https://png.pngtree.com/background/20210711/original/pngtree-financial-fashion-simple-stock-market-webpage-advertising-banner-background-picture-image_1168956.jpg"
                class="img-fluid" alt="Group banner">
            <h3 class="mt-3">{{$group->group_description}}</h3>
            <p class="text-muted">Created on {{$group->group_date}}</p>         
            <h5 class="mt-3">{{$group->group_name}}</h5>
            @if(Auth::user()->id == $group->id_owner)
                    <form action="{{ route('editgroupdescription', ['id_group' => $group->id_groups]) }}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-outline-alsert mx-1">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z" />
                                <path fill-rule="evenodd"
                                    d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z" />
                            </svg>
                    </form>
            @endif        
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="group-stats d-flex align-items-center">
                        <span class="stat-number mr-3">{{ GroupController::posts($group->id_groups) }}</span>
                        <span class="stat-label">Posts</span>
                    </div>
                 <!-- add likes from coment section  2 -->
                    @if(Auth::user()->id == $group->id_owner)
                    <form method="POST" action="{{ route('groupdelete', ['id_group' => $group->id_groups]) }}">
                        @csrf
                        @method('POST')
                        <button type="submit" onclick="myFunction()" class="btn btn-danger btn-sm">DELETE GROUP</button>
                    </form>
                    @else
                    <form method="GET" action="{{ route('groupleave', ['id_group' => $group->id_groups]) }}">
                        <button type="submit" class="btn btn-danger btn-sm">Exit group</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-3 timeline-tweet" style="border: none;">
    <div class="card-body">
        <div class="media">
            <img src="https://images.unsplash.com/photo-1633332755192-727a05c4013d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8dXNlcnxlbnwwfHwwfHw%3D&w=1000&q=80"
                class="mr-3 rounded-circle" width="50" alt="avatar">
            <div class="media-body">
                <form method="POST" action="{{ route('groupInsert', ['id_group' => $group->id_groups])}}">
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

    <div class="row mb-3">
        <div class="col-md-6">
            <h5 class="mb-3">Members</h5>
            @if(Auth::user()->id == $group->id_owner)
            <form method="GET" action="{{route('addmembers', ['id_group'=>$group->id_groups])}}">
                <button type="submit" class="btn btn-success btn-block">ADD MEMBERS</button>
            </form>
            @endif
            <ul class="list-group mt-3">
                @foreach($members = GroupController::getMembers($group->id_groups) as $key => $member)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{UserController::requestUsername($member->id_user)}}
                    @if(Auth::user()->id != $member->id_user && Auth::user()->id == $group->id_owner)
                    <form method="GET"
                        action="{{ route('groupremove', ['id_group' => $group->id_groups, 'id_user' => $member->id_user]) }}">
                        <button type="submit" class="btn btn-danger">remove</button>
                    </form>
                    @endif
                </li>
                @endforeach
            </ul>
            
            </div>
<div class="col-md-6">
      <h5>Timeline</h5>
      <div class="timeline">
        @foreach($group_posts = PostController::groupPost($group->id_groups) as $key => $post)
        <div class="timeline-item">
        <ol class="list-unstyled">
  <li class="media mb-3 timeline-tweet">
    <img src="https://images.unsplash.com/photo-1633332755192-727a05c4013d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8dXNlcnxlbnwwfHwwfHw%3D&w=1000&q=80" class="mr-3 rounded-circle" width="50" alt="avatar">
    <div class="media-body">
      <a href="{{route('profilepage', ['id_user' => $post -> id_user])}}" class="username_post" ><h5 class="mt-0 mb-1 font-weight-bold">{{UserController::requestUsername($post->id_user)}}</h5></a>
      {{$post->content}}
      <div class="d-flex justify-content-between align-items-center mt-2">
        <small class="text-muted">{{$post->post_date}}</small>
        <div class="d-flex align-items-center mt-3">
      <form method="GET" action="{{ route('postpage', ['id_post' => $post->id]) }}" >
      <button type="submit" class="btn btn-outline-secondary">
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chat-dots" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.682.716-2.499 1.862z"/>
          <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
        </svg>
      </button>
      </form>
      @if($post->id_user == Auth::user()->id)
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
</ol>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>

            <!-- Add comented code after adding laravel integration 1 -->

            <script>
            function myFunction() {
                if (confirm("Are you sure you want to delete the group?")) {
                    return true;
                } else {
                    return false;
                }
            }
            </script>
            @endsection

      
