<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\TestResponse;
use Symfony\Component\HttpFoundation\Cookie;
use Tests\TestCase;

class ApiAuthTestCase extends TestCase
{
    use RefreshDatabase;

    protected $invalidEmail = 'invalid@example.com';

    protected $invalidPassword = 'invalid';

    protected $loginRoute;

    protected $logoutRoute;

    protected $registerRoute;

    protected $filmListRoute;

    protected $addFilmRoute;

    protected $validEmail = 'john@example.com';

    protected $validPassword = 'password';

    protected function enableCsrfProtection()
    {
        // csrf is disabled when running tests, but we want to turn it on
        // so our token actually gets verified
        // just needs to be something other than 'testing'
        $this->app['env'] = 'development';
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->loginRoute = route('login');
        $this->logoutRoute = route('logout');
        $this->registerRoute = route('register');
        $this->filmListRoute = route('films.index');
        $this->addFilmRoute = route('films.store');
    }

    protected function createUser()
    {
        return User::factory()->create([
            'email' => $this->validEmail,
            'password' => Hash::make($this->validPassword),
        ]);
    }

    protected function fetchXsrfToken()
    {
        return $this->getJson(rtrim(config('sanctum.prefix', 'sanctum'), '/') . '/csrf-cookie');
    }

    protected function getXsrfTokenFromResponse(TestResponse $response): string
    {
        $cookie = collect($response->headers->getCookies())->first(function (Cookie $cookie) {
            return $cookie->getName() === 'XSRF-TOKEN';
        });

        return $cookie ? $cookie->getValue() : '';
    }

    public function getLoggedInUser($params = [])
    {
        $this->enableCsrfProtection();

        $user = User::whereEmail($this->validEmail)->get()->first();
        if (!$user) {
            $user = $this->createUser();
        }

        // set the xsrf token header, just like axios does automatically
        $this->withHeader('X-XSRF-TOKEN', $this->getXsrfTokenFromResponse($this->fetchXsrfToken()));

        $response = $this->postJson($this->loginRoute, array_merge([
            'email' => $this->validEmail,
            'password' => $this->validPassword,
        ], $params));

        // add the user to the response so we can make additional assertions
        $response->user = $user;

        return $response;
    }
}
