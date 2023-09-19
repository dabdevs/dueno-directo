<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNavigationRequest;
use App\Http\Requests\UpdateNavigationRequest;
use App\Models\Navigation;

class NavigationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreNavigationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNavigationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Navigation  $navigation
     * @return \Illuminate\Http\Response
     */
    public function show(Navigation $navigation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Navigation  $navigation
     * @return \Illuminate\Http\Response
     */
    public function edit(Navigation $navigation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNavigationRequest  $request
     * @param  \App\Models\Navigation  $navigation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNavigationRequest $request, Navigation $navigation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Navigation  $navigation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Navigation $navigation)
    {
        //
    }
}
