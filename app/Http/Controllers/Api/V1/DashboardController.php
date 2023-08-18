<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     *  Dashboard index view
     */
    public function index()
    {
        if (Auth::user()->type === null)
            return view('auth.register_user_type');

        return view('dashboard');
    }

    public function registerUserTYpe()
    {
        User::findOrFail(Auth::id())->update(['type' => request('type')]);
        return view('dashboard');
    }
}
