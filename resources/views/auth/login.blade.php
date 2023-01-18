@extends('layouts.app')
@section('content')

<section class="d-flex  justify-content-center">
  <div class="container-fluid">
    <div class="row">
        <div class="col">     
        <h2>Log In</h2>   
        <form method="POST" action="{{ route('login') }}" class = "login">
        {{ csrf_field() }}
        <div class="mb-3">

            <label for="email" class="form-label">Email address</label>
            <input id="email"  class = "form-control" type="email" placeholder="Email Address" name="email" value="{{ old('email') }}" required autofocus aria-describedby="emailHelp">
                @if ($errors->has('email'))
                <span class="error">
                    {{ $errors->first('email') }}
                </span>
                @endif
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>


        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input id="password" class="form-control"  type="password" placeholder="Password" name="password" required>
                @if ($errors->has('password'))
                <span class="error">
                    {{ $errors->first('password') }}
                </span>
                @endif
        </div>
        <div class="mb-3">
                 <div class="mb-3">  <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me              
                </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    
        </form>
        </div>
        <p class="signup">
                    Don't have an account ?
                    <a href="{{ url('/register') }}" onclick="toggleForm();">Sign Up.</a>
                </p>

                <p class="signup">
                Forgot your password ?
                <a href="{{ url('/password/reset') }}"onclick="toggleForm();">Reset Password.</a>
            </p>


    </div>
 
   
  </div>
</section>


@endsection


