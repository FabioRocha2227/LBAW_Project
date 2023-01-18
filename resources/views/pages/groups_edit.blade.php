<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
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
                <h5 class="mt-0 mb-1 font-weight-bold">{{$group->group_description}}</h5>
            </div>
        </li>
        <form action="{{ route('groupdescriptionUpdate', ['id_group' => $group->id_groups]) }}" method="POST" class="mt-4">
        @csrf
        @method('POST')
        <div class="form-group">
            <label for="commentInput">Edit group description</label>
            <textarea class="form-control" id="done" name="done" rows="3" placeholder="Write here to edit..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div> 

@endsection
