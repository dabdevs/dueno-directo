<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     *  Dashboard index view
     */
    public function index()
    {
        return view('dashboard');
    }
}
