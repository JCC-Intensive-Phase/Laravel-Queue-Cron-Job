<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_route_login_has_view()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/login');

        $response
            ->assertStatus(200)
            ->assertSee('Login');
    }
    public function test_route_register_has_view()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/register');

        $response
            ->assertStatus(200)
            ->assertSee('Register');
    }
    public function test_route_root_must_authenticated()
    {
        $response = $this->get('/');

        $response
            ->assertStatus(302)
            ->assertRedirect('/login');
    }
    public function test_authenticated_user_can_access_root_route(){
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/');
        $response->assertOk();
    }
    public function test_authenticated_user_cant_access_login_route(){
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/login');
        $response->assertRedirect("/");
    }
    public function test_authenticated_user_cant_access_register_route(){
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/register');
        $response->assertRedirect("/");
    }
}
