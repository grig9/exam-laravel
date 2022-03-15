<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class HomeController extends Controller
{
    public function show_users()
    {

        $users = User::all()->all();

        return view('users', ['users' => $users]);
    }

    public function show_user($id)
    {
        $user = User::find($id);

        return view('profile_show', ['user' => $user]);
    }

    public function show_user_status($id)
    {
        $user = User::find($id);

        return view('status', ['user' => $user]);
    }

    public function show_user_security($id)
    {
        $user = User::find($id);

        return view('security', ['user' => $user]);
    }

    public function imageForm($id)
    {
        $user = User::find($id);

        return view('media', ['user' => $user]);
    }

    public function storeImage(Request $request)
    {
        $image = $request->file('image');

        $newFileName = $image->store('img/demo/avatars/');

        User::where('id', $request->id)
            ->update(
                [
                    'image' => $newFileName,
                ]
            );
        return redirect()->back();
    }

    public function editForm($id)
    {
        $user = User::find($id);

        return view('edit_user', ['user' => $user]);
    }

    public function updateUser(Request $request)
    {
        User::where('id', $request->id)
            ->update(
                [
                    'name' => $request->name,
                    'title' => $request->title,
                    'phone' => $request->phone,
                    'address' => $request->address
                ]
            );

        return redirect()->route('show.users')
                ->with('success', 'Профиль успешно обновлен!');
    }

    public function createUserForm()
    {
        return view('create_user_form');
    }

    public function create_user(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:1',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('show.users')
            ->with('success', 'Пользователь успешно добавлен');
    }

    public function destroyUser($id)
    {
        User::find($id)->delete();
        return redirect()->route('show.users')
            ->with('success', 'Профиль успешно удален');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login_form');
    }
}
