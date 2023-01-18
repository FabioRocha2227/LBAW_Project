@extends('layouts.app')
@section('content')
<section class="d-flex  justify-content-center">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h2>Create Group</h2>
                <form method="POST" action="{{ route('register_group') }}" class="register">
                    {{ csrf_field() }}
                    <div class="mb-3">
                        <label for="name" class="form-label">Group Name</label>
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required
                            autofocus aria-describedby="name">
                        @if ($errors->has('name'))
                        <span class="error">
                            {{ $errors->first('name') }}
                        </span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Create Group</button>
                </form>
            </div>
        </div>
    </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the footer element
    var footer = document.querySelector('.footer');

    // Add the fixed-bottom class to the footer element
    footer.classList.add('fixed-bottom');
});
</script>
@endsection