@extends('layouts.notifications')

@section('menu')
  @include('partials.menu')
@endsection

@section('notification')
@foreach($notification as $key => $data)
<div class="post">
        <div class="post__body">
          <div class="post__header">
            <div class="post__headerText">
              <h3>
                 Id : {{$data -> id_notifications}}
              </h3>
            </div>
            <div class="post__headerDescription">
              <p>Text : {{$data -> code}}</p>
              <p>Date : {{$data -> not_date}}</p>
            </div>
          </div>
        </div>
      </div>
@endforeach
@endsection