@extends('layouts.app')
@section('content')

<section class="d-flex  justify-content-center">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h2>Reset Password </h2>

                <form method="POST" action="/password/reset" class="login">
                    {{ csrf_field() }}
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input id="email" class="form-control" type="email" value= {{$email}} name="email"
                            value="{{ old('email') }}" readonly aria-describedby="emailHelp">
                        @if ($errors->has('email'))
                        <span class="error">
                            {{ $errors->first('email') }}
                        </span>
                        @endif
                    </div>  
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input id="password" class="form-control" type="password" placeholder="Password" name="password"
                            required>
                        @if ($errors->has('password'))
                        <span class="error">
                            {{ $errors->first('password') }}
                        </span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="confirmationpassword" class="form-label">Confirm New Password</label>
                        <input id="confirmationpassword" class="form-control" type="password" placeholder="Repeat Password" name="password_confirmation"
                            required>
                        @if ($errors->has('password'))
                        <span class="error">
                            {{ $errors->first('password') }}
                        </span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Send Password Reset Email</button>
                </form>
            </div>
        </div>
    </div>
</section>


@endsection