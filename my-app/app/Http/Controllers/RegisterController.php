<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
  public function register_form() 
  {
    return view('register_form');
  }

  public function register_user(Request $request) {

    $request->validate([
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:1',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    return redirect()
        ->route('login')
        ->with('success', 'Вы успешно зарегистрировались.');
}
}