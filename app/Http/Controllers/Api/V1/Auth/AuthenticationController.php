<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Events\User\UserCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Requests\Api\V1\User\CreateRequest;
use App\Http\Resources\NavigationResource;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Resources\UserResource;
use App\Models\Navigation;
use App\Models\Role;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticationController extends Controller
{
    /**
     *  Register a new user
     */
    public function register(CreateRequest $request)
    {
        try {
            User::create(array_merge($request->only(['email', 'role']), ['password' => bcrypt($request->password)]))->assignRole($request->role);
            
            return response()->json([
                'status' => 'OK',
                'message' => 'User registered successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     *  Login 
     */
    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only(['email', 'password']);  
            
            // Validate login creadentials
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['status' => 'Error', 'message' => 'Wrong credentials'], 401);
            }
            $user = auth()->user();
            $roles = $user->roles->pluck('name')->toArray();
            $token = JWTAuth::fromUser($user, ['roles' => $roles]);
            $navigation = NavigationResource::collection(Navigation::whereJsonContains('allowed_roles', $user->role)->whereActive(1)->get());

            return response()->json([
                'token' => $token, 
                'user' => new UserResource($user),
                'roles' => $user->getRoleNames(),
                'permissions' => $user->getAllPermissions()->pluck('name')->toArray(),
                'navigation' => $navigation
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json([
                'status' => 'Error',
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
            return response()->json(['message' => 'Token refreshed', 'token' => $token]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'Error',
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
