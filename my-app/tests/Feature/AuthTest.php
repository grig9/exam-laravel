<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;


class AuthTest extends TestCase
{
    // use RefreshDatabase;
    use WithoutMiddleware;
    /**
     * A basic test example.
     *
     * @return void
     */
    /** @test */
    public function usersView()
    {
        $response = $this->get('users');

        $response->assertStatus(200);
    }
    
    public function registration()
    {
        $data = [
            'name' => 'john',
            'email' => 'john@email.com',
            'password' => 'secret'
        ];

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'john',
            'email' => 'john@email.com'
        ]);
    }
}
