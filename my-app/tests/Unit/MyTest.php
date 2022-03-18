<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\Controller\RegisterController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;

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
        //регистрируем пользователя
        $user = User::factory()->create([
            'password' => Hash::make('secret')
        ]);
              
        $response = $this->actingAs($user)->get(route('show.user', ['id' => $user->id]));

        $response->assertOk();
        $response->assertSee($user->name);
        
    }

    public function test_show_user_edit()
    {
         //регистрируем пользователя
         $user = User::factory()->create([
            'password' => Hash::make('secret')
        ]);   

        $response = $this->actingAs($user)->get(route('show.user.edit',['id' => $user->id]));

        $response->assertOk();
        $response->assertSeeText('Общая информация');
        
    }

    public function test_user_delete()
    {
        //регистрируем пользователя
        $user = User::factory()->create([
            'password' => Hash::make('secret')
        ]);   

        $response = $this->actingAs($user)->get(route('delete.user', ['id' => $user->id]));

        $response->assertRedirect(route('show.users'));

        $response->assertSessionHas('success', 'Профиль успешно удален');
 
        $this->assertDatabaseMissing('users', [
            'email' => $user->email,
        ]);

    }

    public function test_user_logout()
    {
         //регистрируем пользователя
         $user = User::factory()->create([
            'password' => Hash::make('secret')
        ]);   

        $response = $this->actingAs($user)->get(route('logout'));

        $response->assertRedirect(route('login.form'));

    }

}
