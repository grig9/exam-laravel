<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function users()
    {
        $response = $this->get('/users');

        $response->assertStatus(200);
    }

    /** @test */
    public function show_user()
    {
        $response = $this->get('/user/2');

        $response->assertStatus(200);
    }

    /** @test */
    public function show_user_status()
    {
        $response = $this->get('/status/2');

        $response->assertStatus(200);
    }

    /** @test */
    public function show_user_security()
    {
        $response = $this->get('/security/2');

        $response->assertStatus(200);
    }

    /** @test */
    public function show_user_image()
    {
        $response = $this->get('/media/2');

        $response->assertStatus(200);
    }

    /** @test */
    public function edit_form()
    {
        $response = $this->get('/edit_user/2');

        $response->assertStatus(200);
    }

    /** @test */
    public function create_user_form()
    {
        $response = $this->get('/create_user_form');

        $response->assertStatus(200);
    }
}
