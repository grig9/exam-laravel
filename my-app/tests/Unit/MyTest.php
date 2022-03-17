<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MyTest extends TestCase
{
    use RefreshDatabase;
    // use WithoutMiddleware;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_show_user()
    {
        $data = [
            'email' => 'john@email.com',
            'password' => 'secret'
        ];

        $user = User::register($data);
              
        $response = $this->actingAs($user)->get(route('show.user', ['id' => $user->id]));

        $response->assertOk();
        $response->assertSee($user->name);
        
    }

    public function test_show_user_edit()
    {
        $data = [
            'email' => 'john@email.com',
            'password' => 'secret'
        ];

        $user = User::register($data);    

        $response = $this->actingAs($user)->get(route('show.user.edit',['id' => $user->id]));

        $response->assertOk();
        $response->assertSeeText('Общая информация');
        
    }

    public function test_user_delete()
    {
        $data = [
            'email' => 'john@email.com',
            'password' => 'secret'
        ];

        $user = User::register($data);    

        $response = $this->actingAs($user)->get(route('delete.user', ['id' => $user->id]));

        $response->assertRedirect(route('show.users'));

        $response->assertSessionHas('success', 'Профиль успешно удален');
 
        $this->assertDatabaseMissing('users', [
            'email' => $data['email'],
        ]);

    }

    public function test_user_logout()
    {
        $data = [
            'email' => 'john@email.com',
            'password' => 'secret'
        ];

        $user = User::register($data);    

        $response = $this->actingAs($user)->get(route('logout'));

        $response->assertRedirect(route('login.form'));

    }

}
