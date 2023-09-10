<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Tenant\CreateRequest as TenantCreateRequest;
use App\Http\Requests\Api\V1\User\CreateRequest;
use App\Http\Requests\Api\V1\User\UpdateRequest;
use App\Http\Resources\PropertyResource;
use App\Http\Resources\TenantResource;
use App\Http\Resources\UserResource;
use App\Models\Property;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
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
            $user = User::create(array_merge($request->except('password'), ['password' => Hash::make($request->password)]));

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
    public function update(UpdateRequest $request, $id)
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

            $user->update($request->except(['email', 'password', 'role']));

            return response()->json([
                'status' => 'OK',
                'message' => 'User updated successfully!',
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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
    public function properties(User $user)
    {
        try {
            return response()->json([
                'status' => 'OK',
                'data' => PropertyResource::collection($user->properties)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
