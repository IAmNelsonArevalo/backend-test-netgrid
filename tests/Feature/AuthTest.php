<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * This function test the login endpoint.
     * @return void
     */
    public function test_can_login_the_user(): void
    {
        $loginData = [
            "email" => "nelson.arevalo2119@gmail.com",
            "password" => "Password"
        ];

        $response = $this->post("/api/auth/login", $loginData);

        $response->assertStatus(200);
        $response->assertJsonPath("data.user.name", "Nelson Eduardo Arevalo Cubides");
    }

    public function test_can_register_the_user(): void
    {
        $registerData = [
            "name" => "Nelson Eduardo Arevalo Cubides Prueba 2",
            "email" => "nelson_arevalo14@hotmail.com",
            "password" => "Password",
            "address" => "Calle 38 B Sur # 50 C - 07",
            "complement" => "Piso 2",
            "city" => "Bogota D.C.",
            "birthday" => "1996-05-06"
        ];

        $response = $this->post("/api/auth/register", $registerData);
        $response->assertJsonPath("data.name", $registerData["name"]);
        $response->assertStatus(200);
    }

    public function test_can_active_user(): void
    {
        $id = base64_encode(3);
        $response = $this->get("/api/auth/active_user/$id");
        $response->assertStatus(200);
        $response->assertJsonPath("data.status_id", 1);
        $response->assertJsonPath("data.id", 3);
    }
}
