<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PropertyApplication;

class PropertyApplicationController extends Controller
{
    public function submitApplication(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'property_id' => 'required|exists:properties,id',
            // Add other validation rules as needed
        ]);

        // Create a new property application
        $application = PropertyApplication::create([
            'property_id' => $validatedData['property_id'],
            'tenant_id' => auth()->user()->id, // Assuming you have authentication set up
            'status' => 'pending', // Initial status
        ]);

        return response()->json(['message' => 'Application submitted successfully']);
    }

    public function getApplications()
    {
        // Retrieve property applications for the authenticated user (property owner)
        $applications = PropertyApplication::where('property_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['applications' => $applications]);
    }
}
