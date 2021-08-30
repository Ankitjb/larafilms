<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegistrationTest extends ApiAuthTestCase
{
    /** @test */
    public function canRegister()
    {
        $response = $this->attemptToRegister();
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'email' => $this->validEmail
        ]);
    }

    protected function attemptToRegister(array $params = [])
    {
        return $this->postJson($this->registerRoute, array_merge([
            'name' => 'John',
            'email' => $this->validEmail,
            'password' => $this->validPassword,
            'password_confirmation' => $this->validPassword,
        ], $params));
    }

    /** @test */
    public function cannotRegisterWithRegisteredEmailAddress()
    {
        $this->attemptToRegister();
        Auth::logout();
        $this->assertGuest();

        $this->attemptToRegisterAndExpectFail([
            'email' => User::first()->email,
        ]);
    }

    protected function attemptToRegisterAndExpectFail(array $params)
    {
        $response = $this->attemptToRegister($params);
        $data = $response->getData();
        $this->assertFalse($data->success);
        $this->assertEquals("The email has already been taken.", $data->message->email[0]);
        return $response;
    }
}
