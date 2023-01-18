@extends('layouts.app')

@section('content')

<!-- Custom styles -->
<style>
.banned-message {
    animation: fadeIn 2s ease-in;
    color: #dc3545;
    font-size: 2rem;
    text-align: center;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}
</style>

<script>
var nav = document.querySelector('.navbar');
nav.innerHTML = '';
</script>
<section class="d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="banned-message">You have been banned from our services</h1>
                <p class="lead mt-4">Your account has been banned due to a violation of our terms of service. You are no
                    longer allowed to use our services.</p>
                <p class="lead mt-4">If you believe this was a mistake, please contact us at <a
                        href="mailto:support@useless.com">support@useless.com</a> for assistance. Otherwise, we suggest
                    finding another service to use.</p>
                <p class="mt-4">
                    <a href="{{ url('/logout') }}" class="btn btn-primary">Go to login</a>
                </p>
            </div>

        </div>
    </div>
</section>


@endsection