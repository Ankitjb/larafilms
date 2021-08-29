<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class UserRepository implements UserRepositoryInterface
{
    public function register($data)
    {
        try {
            $validator = Validator::make($data,[
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            if ($validator->fails()) {
                return  [
                    'success' => false,
                    'message' => $validator->errors(),
                ];
            }

            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->save();

            $success = true;
            $message[0] = 'User register successfully';
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message[0] = $ex->getMessage();
        }

        // response
        $response = [
            'success' => $success,
            'message' => $message,
        ];

        return $response;
    }

    public function login($data)
    {
        $validator = Validator::make($data,[
            'email' => 'required|string|email|max:255',
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return  [
                'success' => false,
                'message' => $validator->errors(),
            ];
        }

        $credentials = [
            'email' => $data['email'],
            'password' => $data['password'],
        ];

        if (Auth::attempt($credentials)) {
            $success = true;
            $message[0] = 'User login successfully';
        } else {
            $success = false;
            $message[0] = ['Invalid Username/Password'];
        }

        // response
        $response = [
            'success' => $success,
            'message' => $message,
        ];

        return $response;
    }

    public function logout()
    {
        try {
            Session::flush();
            $success = true;
            $message[0] = 'Logged out successfully';
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message[0] = $ex->getMessage();
        }

        // response
        $response = [
            'success' => $success,
            'message' => $message,
        ];

        return $response;
    }
}
