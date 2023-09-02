<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Tenant\CreateRequest as TenantCreateRequest;
use App\Http\Requests\Api\V1\User\CreateRequest;
use App\Http\Requests\Api\V1\User\UpdateRequest;
use App\Http\Resources\TenantResource;
use App\Http\Resources\UserResource;
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
        return response()->json([
            'status' => 'Success',
            'users' => UserResource::collection(User::all())
        ]);
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
                'status' => 'Ok',
                'message' => 'User created successfuly!',
                'user' => new UserResource($user)
            ], 201);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => 'Error',
                'message' => 'Internal error!'
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
                    'status' => 'Ok',
                    'message' => 'User not found!'
                ], 404);
            }

            return response()->json([
                'status' => 'Ok',
                'user' => new UserResource($user)
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => 'Error',
                'message' => 'Internal error!'
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
                    'status' => 'Ok',
                    'message' => 'User not found!'
                ], 404);
            }

            $user->update($request->except(['email', 'password', 'role']));

            return response()->json([
                'status' => 'Success',
                'message' => 'User updated successfully!',
                'user' => new UserResource($user)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Internal error!'
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
                    'status' => 'Ok',
                    'message' => 'User not found!'
                ], 404);
            }

            $user->delete();

            return response()->json([
                'status' => 'Success',
                'message' => 'User deleted successfully!'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => 'Error',
                'message' => 'Internal error!'
            ], 500);
        }
    }

    public function profile(User $user)
    {
        try {
            return response()->json([
                'status' => 'Ok',
                'profile' => new TenantResource($user->profile)
            ], 201);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => 'Error',
                'message' => 'Internal error!'
            ], 500);
        }
    }
}
