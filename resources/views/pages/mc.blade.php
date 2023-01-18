@extends('layouts.messages')

@section('menu')
  @include('partials.menu')
@endsection


@section('message')
@foreach($message as $key => $data)
<div class="post">
        <div class="post__avatar">
          <img
            src="https://i.pinimg.com/originals/44/32/7f/44327f3b4d9a3152e38cf03132dd8d2d.jpg"
            alt=""
          />
        </div>

        <div class="post__body">
          <div class="post__header">
            <div class="post__headerText">
              <h3>
                Sender: {{$data -> sender}}
                <span class="post__headerSpecial"
                  ><span class="material-icons post__badge"> verified </span>@oldbutgold </span
                >
              </h3>
            </div>
            <div class="post__headerDescription">
              <p>Text: {{$data -> content}} </p>
              <p>Date:{{$data -> msg_date}} </p>
            </div>
          </div>
        </div>
      </div>
      @endforeach
@endsection