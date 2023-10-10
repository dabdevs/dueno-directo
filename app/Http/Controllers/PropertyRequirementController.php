<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyRequirementRequest;
use App\Http\Requests\UpdatePropertyRequirementRequest;
use App\Models\PropertyRequirement;

class PropertyRequirementController extends Controller
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
     * @param  \App\Http\Requests\StorePropertyRequirementRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePropertyRequirementRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PropertyRequirement  $propertyRequirement
     * @return \Illuminate\Http\Response
     */
    public function show(PropertyRequirement $propertyRequirement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PropertyRequirement  $propertyRequirement
     * @return \Illuminate\Http\Response
     */
    public function edit(PropertyRequirement $propertyRequirement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePropertyRequirementRequest  $request
     * @param  \App\Models\PropertyRequirement  $propertyRequirement
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePropertyRequirementRequest $request, PropertyRequirement $propertyRequirement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PropertyRequirement  $propertyRequirement
     * @return \Illuminate\Http\Response
     */
    public function destroy(PropertyRequirement $propertyRequirement)
    {
        //
    }
}
