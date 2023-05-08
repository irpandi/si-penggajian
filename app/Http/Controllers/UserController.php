<?php

// * Author By : Rifki Irpandi

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // * Show Login Form
    public function loginForm()
    {
        return view('login.index');
    }

    // * Method action login
    public function login(Request $req)
    {
        $credentials = $req->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $req->session()->regenerate();
            return redirect()->route('home.index');
        }

        return back()->withErrors([
            'failed' => 'Username or password is wrong',
        ]);
    }

    // * Method action logout
    public function logout(Request $req)
    {
        Auth::logout();

        $req->session()->invalidate();
        $req->session()->regenerateToken();

        return redirect()->route('login.signin');
    }

    // * Method for check application health
    public function health()
    {
        $data = array(
            'code'     => 200,
            'response' => 'Healthy',
        );

        return response()->json($data);
    }
}
