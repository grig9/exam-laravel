<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ExampleTest extends TestCase
{
    // use WithoutMiddleware;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_login_form()
    {
        $response = $this->get(route('login.form'));
        $response->assertStatus(200);
    }

    public function test_register_form()
    {
        $response = $this->get(route('register.form'));
        $response->assertStatus(200);
    }

    public function test_users_show()
    {
        $response = $this->get(route('show.users'));

        $response->assertStatus(200);
        $response->assertSee('Вы не авторизированы');

        $response->assertViewHas('users');
    }

    
    

}
