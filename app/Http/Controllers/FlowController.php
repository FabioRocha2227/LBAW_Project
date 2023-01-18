<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Card;


class FlowController extends Controller
{
    public function app()
    {
    return $this->view('pages.mc');    
    }
    public function messages()
    {
    return view('pages.mc');
    }
    public function notifications()
    {
    return view('pages.notifications');
    }
    public function profile()
    {
    return view('pages.profile');
    }
    public function settings()
    {
    return view('pages.settings');
    }

    
}
