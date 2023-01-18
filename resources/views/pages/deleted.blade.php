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
                <h1 class="banned-message">The account you're trying to access has been deleted</h1>
                <p class="lead mt-4">We're sorry, but the account you are trying to access has been deleted. This could
                    be due to a violation of our terms of service, or because the owner of the account has chosen to
                    delete it.</p>
                <p class="lead mt-4">If you believe this was a mistake, please contact us at <a
                        href="mailto:support@useless.com">support@example.com</a> for assistance.</p>
                <p class="mt-4">
                    <a href="{{ url('/logout') }}" class="btn btn-primary">Go to login</a>
                </p>
            </div>
        </div>
    </div>
</section>


@endsection