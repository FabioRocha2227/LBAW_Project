@extends('layouts.app')
@section('content')

<section class="d-flex  justify-content-center">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h2>Log In</h2>
                <form method="POST" action="/password/email" class="login">
                    {{ csrf_field() }}
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input id="email" class="form-control" type="email" placeholder="Email Address" name="email"
                            value="{{ old('email') }}" required autofocus aria-describedby="emailHelp">
                        @if ($errors->has('email'))
                        <span class="error">
                            {{ $errors->first('email') }}
                        </span>
                        @endif
                        <div id="emailHelp" class="form-text">Fill with the email of your acount.</div>
                    </div>    
                    <button type="submit" class="btn btn-primary">Send Password Reset Email</button>
                </form>
            </div>
        </div>
    </div>
</section>


@endsection