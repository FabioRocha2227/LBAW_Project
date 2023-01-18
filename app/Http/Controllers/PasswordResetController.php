<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\PasswordResetEmail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Auth\Events\PasswordReset;

class PasswordResetController extends Controller
{
    public function create()
    {
        return view('pages.passwordrecovery'); 
       
    }

    public function store(Request $request)
    {
    $request->validate([
        'email' => 'required|email',
    ]);
        $user = User::where('email', $request->email)->first();
    if ($user) {
        $token =Str::random(60);
        $test = DB::table('users')->where('email',$request->email)->update(array('password_reset_token' =>  $token));
        $user->password_reset_token = $token;
        $user->save();

        $user->notify(new PasswordResetEmail($user));
        // Display a success message
        return redirect('/password/reset')->with('status', 'Password reset email sent');
    }
    }
    public function edit($token)
    {
        
    $user = User::where('password_reset_token', $token)->first();


    return view('pages.passemail', [
        'token' => $token,
        'email' => $user->email,
    ]);
   

    }

    public function update(Request $request)
    {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|confirmed',
    ]);

    $user = User::where('password_reset_token', $request->token)->where('email', $request->email)->first();
    if (!$user) {
        // Return an error if the token is invalid or the email does not match
    }

    // Reset the user's password and clear the password reset token
    $user->password = Hash::make($request->password);
    $user->password_reset_token = null;
    $user->save();

    // Display a success message and redirect the user to the login page
    return redirect('/login')->with('status', 'Your password has been reset');
    }

}