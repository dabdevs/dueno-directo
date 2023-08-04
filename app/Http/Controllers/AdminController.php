<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\CreateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display the view to create a user.
     *
     */
    public function createUserView()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createUserAction(CreateUserRequest $request)
    { 
        dd($request->all());
        $default_password = ($request->given_name)[0] . '_' . ($request->family_name)[0] . $request->type;
        $password = ['password' => Hash::make($default_password)];
        $user_data = array_merge($request->only('email', 'type', 'given_name', 'family_name'), $password);
        dd($user_data);
        User::create($user_data); 
    }
}
