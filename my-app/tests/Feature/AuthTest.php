<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\Controller\RegisterController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class AuthTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    
    /** @test */
    public function checkRegistrationValidation()
    {
        $response = $this->post(route('register'), [
            'email' => 'john@email.com',
            'password' => 'secret'
        ]);

        $response->assertValid();
        
    }

    /** @test */
    public function checkRegistration()
    {
        $response = $this->post(route('register'), [
            'email' => 'john@email.com',
            'password' => 'secret'
        ]);

        $response->assertRedirect(route('login.form'));
        $response->assertSessionHas('success', 'Вы успешно зарегистрировались.');

        $this->assertDatabaseHas('users', [
            'email' => 'john@email.com'
        ]);
    }

    /** @test */
    public function userLogin()
    {
        //регистрируем пользователя
        $user = User::factory()->create([
            'password' => Hash::make('secret')
        ]);
        // login $user
        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'secret'
        ]);

        $response->assertRedirect(route('show.users'));
        $response->assertSessionHas('success', 'Успешная авторизация');

    }

    /** @test */
    public function errorUserLogin()
    {
        //регистрируем пользователя
        $user = User::factory()->create([
            'password' => Hash::make('secret')
        ]);
        // login $user
        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'false_password'
        ]);

        $response->assertSessionHas('error', 'The provided credentials do not match our records.');

    }
}
