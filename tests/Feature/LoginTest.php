<?php

namespace Tests\Feature;


class LoginTest extends ApiAuthTestCase
{
    /** @test */
    public function guestCanLoginWithCorrectCredentials()
    {
        $response = $this->getLoggedInUser([
            'email' => $this->validEmail,
            'password' => $this->validPassword,
        ]);

        $response->assertStatus(200);
        $this->assertAuthenticatedAs($response->user);
    }

    /** @test */
    public function guestCanLoginWithWrongCredentials()
    {
        $response = $this->getLoggedInUser([
            'email' => $this->validEmail,
            'password' => $this->invalidPassword,
        ]);
        $data = $response->getData();
        $this->assertFalse($data->success);
    }
}
