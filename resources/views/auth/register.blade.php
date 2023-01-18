@extends('layouts.app')

@section('content')
<section class="d-flex  justify-content-center">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h2>Register</h2>

                <form method="POST" action="{{ route('register') }}" class="register">
                    {{ csrf_field() }}
                    <div class="mb-3">
                        <label for="name" class="form-label">Username</label>
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required
                            autofocus aria-describedby="name">
                        @if ($errors->has('name'))
                        <span class="error">
                            {{ $errors->first('name') }}
                        </span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input id="email" class="form-control" type="email" placeholder="Email Address" name="email"
                            value="{{ old('email') }}" required autofocus aria-describedby="emailHelp">
                        @if ($errors->has('email'))
                        <span class="error">
                            {{ $errors->first('email') }}
                        </span>
                        @endif
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label"> Password</label>
                        <input id="password" class="form-control" type="password" placeholder="Password" name="password"
                            required>
                        @if ($errors->has('password'))
                        <span class="error">
                            {{ $errors->first('password') }}
                        </span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="confirmationpassword" class="form-label">ConfirmPassword</label>
                        <input id="confirmationpassword" class="form-control" type="password"
                            placeholder="Repeat Password" name="password_confirmation" required>
                        @if ($errors->has('password'))
                        <span class="error">
                            {{ $errors->first('password') }}
                        </span>
                        @endif
                    </div>



                    <div class="mb-3">
                        <label for="full_name" class="form-label">Name</label>
                        <input id="full_name" type="text" class="form-control" name="full_name"
                            value="{{ old('full_name') }}" required autofocus aria-describedby="full_name">
                        @if ($errors->has('full_name'))
                        <span class="error">
                            {{ $errors->first('full_name') }}
                        </span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input id="phone" type="tel" pattern="9[1-9][0-9]{7}" class="form-control" name="phone"
                            value="{{ old('phone') }}" required autofocus aria-describedby="phone">
                        @if ($errors->has('phone'))
                        <span class="error">
                            {{ $errors->first('phone') }}
                        </span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="birthdate" class="form-label">Birthdate</label>
                        <input id="birthdate" type="date" class="form-control" name="birthdate"
                            value="{{ old('birthdate') }}" required autofocus aria-describedby="birthdate">
                        @if ($errors->has('birthdate'))
                        <span class="error">
                            {{ $errors->first('birthdate') }}
                        </span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}"
                            required autofocus aria-describedby="address">
                        @if ($errors->has('address'))
                        <span class="error">
                            {{ $errors->first('address') }}
                        </span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="civil_state" class="form-label">Civil State</label>
                        <input id="civil_state" type="text" class="form-control" name="civil_state"
                            value="{{ old('civil_state') }}" required autofocus aria-describedby="civil_state">
                        @if ($errors->has('civil_state'))
                        <span class="error">
                            {{ $errors->first('civil_state') }}
                        </span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <input type="radio" id="male" name="gender" value="M">
                        <label for="M" class="form-label">Male</label>
                        <input type="radio" id="female" name="gender" value="F">
                        <label for="f" class="form-label">Female</label>
                        <input type="radio" id="other" name="gender" value="O">
                        <label for="O" class="form-label">Other</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
            <p class="signup">
                Already have an account ?
                <a href="{{ url('/login') }}" onclick="toggleForm();">Log In.</a>
            </p>
        </div>
    </div>
</section>
@endsection