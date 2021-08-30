<?php

namespace App\Http\Controllers\API\V1;

use Session;
use Illuminate\Http\Request;
use App\Repositories\UserRepositoryInterface;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * This function use for Register
     */
    public function register(Request $request)
    {
        $response = $this->userRepository->register($request->all());
        return response()->json($response);
    }

    /**
     * This function use for Login
     */
    public function login(Request $request)
    {
        $response = $this->userRepository->login($request->all());
        return response()->json($response);
    }

    /**
     * This function use for Logout
     */
    public function logout()
    {
        $response = $this->userRepository->logout();
        return response()->json($response);
    }
}
