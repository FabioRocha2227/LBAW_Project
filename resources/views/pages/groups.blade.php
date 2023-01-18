<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\GroupController;
?>

@extends('layouts.app')

@section('content')
<style>
  .card{
    margin-bottom: 1em;
  }

  .card {
  transition: box-shadow 0.2s ease;
}

.card:hover {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
}


</style>

        
<div class="container">
  <form class="d-flex justify-content-end mt-3 mb-3" method="GET" action="{{route('creategroup')}}">
    <button type="submit" class="btn btn-success">CREATE GROUP</button>
  </form>
  <div class="row">
    @foreach($groups = GroupController::showGroups(Auth::user()->id) as $key => $group)
    <div class="col-md-4">
      
      <div class="card mb-3">
        <img src="https://images.unsplash.com/photo-1633332755192-727a05c4013d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8dXNlcnxlbnwwfHwwfHw%3D&w=1000&q=80" class="card-img-top" alt="Group 1">
        <div class="card-body">
          <h5 class="card-title">{{$group->group_description}}</h5>
          <h6 class="card-title">{{$group->group_name}}</h6>
          <p class="card-text"><small class="text-muted">Created on {{$group->group_date}}</small></p>
          <div class="d-flex justify-content-between align-items-center">
            <p class="card-text mb-0">Members: {{GroupController::members($group->id_groups)}}</p>
            <p class="card-text mb-0">Posts: {{GroupController::posts($group->id_groups)}}</p>
          </div>
          <form class="d-flex justify-content-end" method="GET" action="{{ route('groupspage', ['id_group' => $group->id_groups]) }}" >
            <button type="submit" class="btn btn-primary">View</button>
          </form>
        </div>
      </div>
    </div>
    @endforeach
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