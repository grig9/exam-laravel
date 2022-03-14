<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
  public function create()
  {
    return view('login_form');
  }

  public function store(Request $request)
  {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();

      return redirect('users');
    }

    return redirect('login_form')->withErrors([
      'email' => 'The provided credentials do not match our records.',
    ]);
  }
}
