<?php

namespace Tests\Feature;

use App\Models\User;

class LogoutTest extends ApiAuthTestCase
{
    /** @test */
    public function userCanLogout()
    {
        $this->postJson($this->loginRoute, [
            'email' => User::factory()->create()->email,
            'password' => 'password',
        ])->json();

        $response = $this->postJson($this->logoutRoute)
            ->assertSuccessful();

        $response->assertOk();
        $data = $response->getData();
        $this->assertEquals("Logged out successfully", $data->message[0]);
    }
}
