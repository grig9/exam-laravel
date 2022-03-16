<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Gate;


class HomeController extends Controller
{
    public function show_users()
    {

        $users = User::all()->all();

        return view('users', ['users' => $users]);
    }

    public function showUser($id)
    {
        $user = User::find($id);

        return view('profile_show', ['user' => $user]);
    }

    public function show_user_status($id)
    {   
        if (!Gate::allows('edit-user', $id) and !request()->user()->is_admin) {
            return redirect()->route('show.users')->with('error', 'Отказано в доступе');
        }

        $user = User::find($id);

        $status_list = User::getStatuses();

        return view('status', ['user' => $user, 'statuses' => $status_list]);
    }

    public function statusStore(Request $request)
    {
        if (!Gate::allows('edit-user', $request->id) and !request()->user()->is_admin) {
            return redirect()->route('show.users')->with('error', 'Вы не можете редактировать других пользователей');
        }

        User::where('id', $request->id)
            ->update(
                [
                    'status' => $request->status
                ]
            );

        return redirect()->route('show.users')
            ->with('success', 'Статус профиля успешно обновлен!');
    }

    public function show_user_security($id)
    {
        if (!Gate::allows('edit-user', $id) and !request()->user()->is_admin) {
            return redirect()->route('show.users')->with('error', 'Отказано в доступе');
        }

        $user = User::find($id);

        return view('security', ['user' => $user]);
    }

    public function securityStore(Request $request)
    {
        if (!Gate::allows('edit-user', $request->id) and !request()->user()->is_admin) {
            return redirect()->route('show.users')->with('error', 'Вы не можете редактировать других пользователей');
        }

        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:1',
            'password_confirmation' => 'same:password',
        ]);

        User::where('id', $request->id)
                ->update(
                    [
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                    ]
                );

        return redirect()->route('show.users')->with('success', 'Профиль успешно обновлен');
    }

    public function imageForm($id)
    {
        if (!Gate::allows('edit-user', $id) and !request()->user()->is_admin) {
            return redirect()->route('show.users')->with('error', 'Отказано в доступе');
        }

        $user = User::find($id);

        return view('media', ['user' => $user]);
    }

    public function storeImage(Request $request)
    {
        if (!Gate::allows('edit-user', $request->id) and !request()->user()->is_admin) {
            return redirect()->route('show.users')->with('error', 'Вы не можете редактировать других пользователей');
        }
        
        $request->validate([
            'image' => 'required|image',
        ]);

        $imageNameFromBd =  User::find($request->id)->only('image');
        Storage::delete($imageNameFromBd);

        $image = $request->file('image')
                            ->store('img/demo/avatars/');

        User::where('id', $request->id)
            ->update(
                [
                    'image' => $image,
                ]
            );
        return redirect()->back()
            ->with('success', 'Аватар успешно обновлен!');
    }

    public function editForm($id)
    {   
        if (!Gate::allows('edit-user', $id) and !request()->user()->is_admin) {
            return redirect()->route('show.users')->with('error', 'Отказано в доступе');
        }

        $user = User::find($id);

        return view('edit_user', ['user' => $user]);
    }

    public function updateUser(Request $request)
    {
        if (!Gate::allows('edit-user', $request->id) and !request()->user()->is_admin) {
            return redirect()->route('show.users')->with('error', 'Вы не можете редактировать других пользователей');
        }

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
        $status_list = User::getStatuses();

        return view('create_user_form', ['statuses' => $status_list]);
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:1',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
        ]);

        return redirect()->route('show.users')
            ->with('success', 'Пользователь успешно добавлен');
    }

    public function deleteUser($id)
    {
        if (!Gate::allows('edit-user', $id) and !request()->user()->is_admin) {
            return redirect()->route('show.users')->with('error', 'Отказано в доступе');
        }

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
