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
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    
    /** @test */
    public function registration()
    {
        $data = [
            'name' => 'john',
            'email' => 'john@email.com',
            'password' => 'secret'
        ];

        User::register($data);

        $this->assertDatabaseHas('users', [
            'name' => 'john',
            'email' => 'john@email.com'
        ]);
    }

    /** @test */
    public function userLogin()
    {
        $data = [
            'email' => 'john@email.com',
            'password' => 'secret'
        ];

        $user = User::register($data);

        $hasUser = $user ? true : false;

        $this->assertTrue($hasUser);


        $response = $this->actingAs($user)->get('/users');
              

    }
}
