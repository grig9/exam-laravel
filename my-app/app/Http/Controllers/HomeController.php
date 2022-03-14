<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class HomeController extends Controller
{
    public function show_users()
    {
        $users = User::all();

        return view('users', ['users' => $users]);
    }

    public function show_user(Request $request, $id)
    {
        // get user

        // $url = secure_asset('css/vendors.bundle.css');
        
        $user = 'test';

        return view('profile_show', ['user' => $user]);
    }

    public function show_user_status(Request $request, $id)
    {
        // get user

        $user = 'test';

        return view('status', ['user' => $user]);
    }

    public function show_user_security(Request $request, $id)
    {
        $user = 'test';

        return view('security', ['user' => $user]);
    }

    public function image_form(Request $request, $id)
    {
        $user = 'test';

        return view('media', ['user' => $user]);
    }

    public function edit_form(Request $request, $id)
    {
        $user = 'test';

        return view('edit_user', ['user' => $user]);
    }


    public function create_user_form()
    {
        return view('create_user_form');
    }

    public function create_user(Request $request)
    {
        // $user = User::create()->fill($request->post());
        return redirect('/user');
    }

    public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/');
}

}
