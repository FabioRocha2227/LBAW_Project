<?php use App\Http\Controllers\UserController;?>
<style>
#search-icon {
    background: none;
    border: none;
    cursor: pointer;
    color: #333;
    font-size: 1.5em;
}


#search-form {
    position: relative;
}


@keyframes growRight {
    from {
        width: 0;
    }

    to {
        width: 300px;
    }
}

@keyframes shrinkRight {
    from {
        width: 300px;
    }

    to {
        width: 0;
    }
}
</style>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid">
            <a class="navbar-brand" href="/cards"><b>US</b>eless</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <form class="form-inline my-2 my-lg-0" method="GET" id="search-form" action="/search"">
                @csrf 
                @method('GET')
                <div class=" input-group ">
                <div class="input-group-append">
                        <button id="search-icon" type="button">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z" />
                                <path fill-rule="evenodd"
                                    d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z" />
                            </svg>
                        </button>

                    </div>
            </div>
                    <input name=" query" class="form-control" type="search" placeholder="Search..." aria-label="Search"
                    id="search-input" style="display: none;">
               
            </form>
            <ul class="navbar-nav ml-auto">
                @if (UserController::requestAdmin(Auth::user()->id) == 1)
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('admin')}}"><i class="fas fa-cog" title="Administration Area"></i></a>
                </li>
                @endif
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('profilepage', ['id_user' => Auth::user()->id])}}"><i
                            class="fas fa-user" title="Profile"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/groups"><i class="fas fa-users" title="Groups"></i></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" title="notifications" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell"></i>
                    </a>
                    <div class="dropdown-menu " aria-labelledby="navbarDropdown">
                        @foreach($friend_request = UserController::fr_notification() as $key => $fr)
                        <a class="dropdown-item" href="#">
                            {{UserController::requestUsername($fr->user_from)}} sent you a friend request!
                            <form action="{{ route('accept_request', ['id' => $fr->id]) }}" method="POST">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-primary mr-2">ACCEPT</button>
                            </form>
                            <form action="{{ route('reject_request', ['id' => $fr->id]) }}" method="POST">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-danger mr-2">REJECT</button>
                            </form>
                        </a>
                        @endforeach
                        @foreach($react = UserController::react_notification() as $key => $data)
                        <a class="dropdown-item" href="{{ route('postpage', ['id_post' => $data->id_post]) }}">
                            <div class="react_notification">
                                <h3>{{UserController::requestUsername($data->user_id)}} liked your Post</h3>
                                <div class="react_notification_footer">
                                    {{$data->react_post_date}}
                                </div>
                            </div>
                        </a>
                        @endforeach

                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" title="Logout" href="{{ url('/logout') }}"><i
                            class="fas fa-sign-out-alt"></i></a>
                </li>
            </ul>
        </div>
        </div>
    </nav>
</header>


<script>
document.getElementById("search-icon").addEventListener("click", function() {
    var searchInput = document.getElementById("search-input");
    if (searchInput.style.display === "none") {
        searchInput.style.display = "block";
        searchInput.style.animation = "growRight 0.3s ease-in-out forwards";
    } else {
        searchInput.style.animation = "shrinkRight 0.3s ease-in-out forwards";
        setTimeout(function() {
            searchInput.style.display = "none";
        }, 300);
    }
});
</script>