<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Login
     *
     * @param  mixed $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginUserRequest $request) {

        $param = $request->validated();

        try {

            $credentials = $request->only('username', 'password');

            // validate credentials
            if (Auth::attempt($credentials, true)) {

                //user data
                $user = User::where('username', $param['username'])->first();

                // generate the access token with the correct scope
                $tokenResult = $user->createToken('User Access Token', ['auth-api']);

                return $tokenResult;

                return response(['message' => 'Sign In Successful', 'data' => ['access_token' => $tokenResult->accessToken, 'user' => New UserResource($user)]], 200);
            } else {
                return response(['message' => array(['password' => 'Invalid password.']), 'success' => Helpers::FAILED], 400);
            }
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 400);
        }
    }
}
