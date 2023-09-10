<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Resources\UserResource;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticationController extends Controller
{
    /**
     *  Register a new user
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create(array_merge($request->only(['email', 'role']), ['password' => bcrypt($request->password)]));

            return response()->json([
                'status' => 'OK',
                'message' => 'User registered successfully',
                'user' => new UserResource($user)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     *  Login 
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        try {
            // Validate login creadentials
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Wrong credentials'], 401);
            }

            return response()->json(['token' => $token]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Could not generate token'
            ], 500);
        }
    }

    /**
     *  Refresh token
     */
    public function refresh()
    {
        $old_token = request()->bearerToken();

        try {
            // Refresh token
            $token = JWTAuth::setToken($old_token)->refresh();
            return response()->json(['token' => $token]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid or expired token'
            ], 401);
        }
    }

    /**
     *  Redirect the user to the Google authentication page
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    /**
     *  Handle the callback from Google
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            // Check if the user already exists in database 
            $user = User::whereEmail($googleUser->email)->first();

            // If the user does not exist, create a new user
            if (!$user) {
                $user = new User();
                $user->given_name = $googleUser->user["given_name"];
                $user->family_name = $googleUser->user["family_name"];
                $user->email = $googleUser->email;
                $user->password = bcrypt('');
                $user->save();
            }

            // Authenticate the user
            Auth::login($user);

            // Redirect to the home page or a dashboard
            return redirect()->intended(RouteServiceProvider::HOME);
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Google authentication failed.');
        }
    }

    /**
     *  Handle user logout
     */
    public function logout()
    {
        Auth::logout();

        // Redirect to the login page
        return redirect('/login');
    }
}
