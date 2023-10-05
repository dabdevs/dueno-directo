<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\CreateRequest;
use App\Http\Requests\Api\V1\User\UpdateRequest;
use App\Http\Resources\PropertyResource;
use App\Http\Resources\TenantResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin')->except(['update', 'profile', 'uploadAvatar', 'myProperties']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $users = User::paginate(10);

            return response()->json([
                'status' => 'OK',
                "data" => UserResource::collection($users),
                'meta' => [
                    'current_page' => $users->currentPage(),
                    'from' => $users->firstItem(),
                    'last_page' => $users->lastPage(),
                    'path' => $users->path(),
                    'per_page' => $users->perPage(),
                    'to' => $users->lastItem(),
                    'total' => $users->total(),
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        try {
            $user = User::create(array_merge($request->except('password'), ['password' => Hash::make($request->password)]))->assignRole($request->role);

            return response()->json([
                'status' => 'OK',
                'message' => 'User created successfuly!',
                'data' => new UserResource($user)
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = User::find($id);

            // If the user is not found
            if (!$user) {
                return response()->json([
                    'status' => 'OK',
                    'message' => 'User not found!'
                ], 404);
            }

            return response()->json([
                'status' => 'OK',
                'data' => new UserResource($user)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(UpdateRequest $request, User $user)
    {
        try {
            // Validate if user have permission to update the resource
            if ($user->id != auth()->id() && auth()->user()->role != User::ROLE_ADMIN) {
                return response()->json([
                    'status' => 'OK',
                    'message' => 'Forbidden'
                ], 403);
            }

            $data = $request->except(['email']);

            if ($request->has('password')) {
                $data['password'] = bcrypt($request->password);
            }

            $user->update($data);

            return response()->json([
                'status' => 'OK',
                'message' => 'User updated successfully!',
                'data' => new UserResource($user)
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();

            return response()->json([
                'status' => 'OK',
                'message' => 'User deleted successfully!'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     *  Return a user's profile
     */
    public function profile(User $user)
    {
        try {
            // Validate if user have permission to view profile
            if ($user->id != auth()->id() && auth()->user()->role != User::ROLE_ADMIN) {
                return response()->json([
                    'status' => 'OK',
                    'message' => 'Forbidden'
                ], 403);
            }

            if ($user->profile == null) {
                return response()->json([
                    'message' => 'User has no profile.',
                ], 400);
            }

            return response()->json([
                'status' => 'OK',
                'data' => new TenantResource($user->profile)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a user's profile
     */
    public function deleteProfile(User $user)
    {
        try {
            if (!$user->profile) {
                return response()->json([
                    'message' => 'User has no profile.'
                ], 400);
            }

            $user->profile->delete();

            return response()->json([
                'status' => 'OK',
                'message' => 'Profile deleted successfuly!'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     *  Authenticated user's properties
     */
    public function myProperties()
    {
        try {
            return response()->json([
                'status' => 'OK',
                'data' => PropertyResource::collection(auth()->user()->properties)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function uploadAvatar(Request $request)
    {
        try {
            $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $user = User::find(auth()->id());

            if ($request->has('avatar')) {
                $path = $request->file('avatar')->store('images/users/avatars/' . $user->id);
                $user->avatar = $path;
                $user->save();
            }

            return response()->json([
                'status' => 'OK',
                'message' => 'Avatar uploaded successfuly.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
