<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class LoginController extends Controller
{
  public function login_form() 
  {
    return view('login_form');
  }

  public function login() 
  {
    return redirect('users');
  }
}