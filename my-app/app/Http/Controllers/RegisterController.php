<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
  public function register_form() 
  {
    return view('register_form');
  }

  public function register(Request $request)
  {
    $data = $request->post();

    $user = new User;
    $user->fill($data);
    $user->name = "noname";
    $user->save();

    return redirect('login_form');
  }
}