<?php

namespace App\Http\Controllers;

use App\Models\OwnerProfile;
use Illuminate\Http\Request;

class OwnerController extends Controller
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
        return view('owner.profile.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the form data (you can add more validation rules as needed)
        $validatedData = $request->validate([
            'phone_number' => 'required|string',
            'address' => 'required|string',
            'property_address' => 'required|string',
            'property_type' => 'required|string',
            'property_description' => 'nullable|string',
            'rental_price' => 'required|numeric',
            'lease_term' => 'required|string',
            'availability' => 'nullable|date',
            'rent_payment_method' => 'required|string',
            'security_deposit' => 'required|numeric',
            'rental_agreement' => 'nullable|string',
            'preferred_tenant_profile' => 'nullable|string',
            'additional_notes' => 'nullable|string',
            // Add validation rules for the rest of the fields
        ]);

        // Create and store the owner profile
        OwnerProfile::create($validatedData); 

        // Redirect to a thank you page or any other page as needed
        return redirect()->route('owner.profile.create')->with('success', 'Owner profile created successfully!');
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
        return view('owner.profile.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
