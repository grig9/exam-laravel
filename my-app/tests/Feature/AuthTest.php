<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthTest extends TestCase
{
    use RefreshDatabase;

     /** @test */
     public function authorize()
     {
        // $user = User::factory()->count(1)->create();
    
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

        $response = $this->post('login', ['email' => $data['email'], 'password' => $data['password'] ]);

        
        $response->assertStatus(200);

        $response = $this->get('logout');
        $response->assertStatus(200);

     }

     
     public function authorizeField()
     {
        $password = 123456;
        $user = User::factory()->create(['password' => bcrypt($password)]);

        $response = $this->post('login-form', ['email' => $user->email, 'password' => $password . '1']);
        $response->assertStatus(301);

        $response = $this->get('roles');
        $response->assertStatus(301);

     }
}
