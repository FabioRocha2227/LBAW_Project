<?php
use App\Http\Controllers\UserController;
?>
<div class="sidebar">

    <div class="">
        <i class="fab fa-twitter"></i>
        <span>Welcome back, {{ Auth::user()->username }} !</span>
    </div>
    <div class=" ">
        <form action="{{ route('profileShow') }}" method="POST">
            @csrf
            @method('POST')
            <input type="text" name="username" placeholder="escreve aqui para procurar">
        </form>
    </div>




    <div class="sidebarOption active" onclick="location.href='{{ url('/') }}';">
        <span class="material-icons"> home </span>
        <h2>Home</h2>
    </div>

    <div class="sidebarOption" onclick="location.href='{{ url('notifications') }}';">
        <span class="material-icons"> notifications_none </span>
        <h2>Notifications</h2>
    </div>

    <div class="sidebarOption" onclick="location.href='{{ url('messages') }}';">
        <span class="material-icons"> mail_outline </span>
        <h2>Messages</h2>
    </div>
    <div class="sidebarOption">
        <a class="sidebarOption"
            href="{{ route('profileShow1', ['username' => UserController::requestUsername(Auth::user()->id)]) }}"><span
                class="material-icons"> perm_identity </span>
            <h2>Profile</h2>
        </a>
    </div>

    <div class="sidebarOption" onclick="location.href='{{ url('settings') }}';">
        <span class="material-icons"> settings </span>
        <h2>Settings</h2>
    </div>

    <a class="button sidebar__tweet" href="{{ url('/logout') }}"> Logout </a>
</div>