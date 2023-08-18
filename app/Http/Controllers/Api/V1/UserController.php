<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Http\Requests\Api\V1\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
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
        return view('admin.user.create', ['users' => User::orderBy('id', 'desc')->paginate(10)]);
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
    public function store(CreateUserRequest $request)
    {
        $password = ['password' => Hash::make($request->password)];
        $user_data = array_merge($request->only('email', 'type', 'given_name', 'family_name'), $password);
        User::create($user_data);

        return redirect()->back()->with('success', 'User created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(UpdateUserRequest $request, $user)
    {
        try {
            $user = User::find($user);

            // If the user is not found
            if (!$user) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'User not found!'
                ], 400);
            }

            // Check if the authenticated user is the user being updated or admin user
            if ($user->id != auth()->id() && auth()->user()->type != "admin") {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Action unauthorized!'
                ], 401);
            }

            $user->update($request->except(['email', 'password', 'type']));

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
        //
    }
}
