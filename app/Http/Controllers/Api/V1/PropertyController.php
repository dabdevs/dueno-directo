<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Property\CreateRequest;
use App\Http\Requests\Api\V1\Property\UpdateRequest;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\PreferenceResource;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a property of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $properties = Property::paginate(10);

            return response()->json([
                "status" => "Ok",
                "data" => PropertyResource::collection($properties),
                'meta' => [
                    'current_page' => $properties->currentPage(),
                    'from' => $properties->firstItem(),
                    'last_page' => $properties->lastPage(),
                    'path' => $properties->path(),
                    'per_page' => $properties->perPage(),
                    'to' => $properties->lastItem(),
                    'total' => $properties->total(),
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
     * Create a property.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        try {
            // Get the user
            $user = $request->has('user_id') ? User::findOrFail($request->user_id) : auth()->user();

            // If user's role is not owner 
            if ($user->role != User::ROLE_OWNER) {
                return response()->json([
                    'message' => 'User is not an owner.'
                ], 401);
            }

            $property = $user->properties()->create($request->validated());

            return response()->json([
                'status' => 'Ok',
                'message' => 'Property created successfully!',
                'data' => new PropertyResource($property)
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
     */
    public function show(Property $property)
    {
        try {
            return response()->json([
                'status' => 'Ok',
                'data' => new PropertyResource($property)
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
    public function update(UpdateRequest $request, Property $property)
    {
        try {
            $property->update($request->validated());

            return response()->json([
                'status' => 'Ok',
                'message' => 'Property updated successfully!',
                'data' => new PropertyResource($property)
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
            $property = Property::find($id);

            // If the property is not found
            if (!$property) {
                return response()->json([
                    'status' => 'Ok',
                    'message' => 'Property not found!'
                ], 404);
            }

            $property->delete();

            return response()->json([
                'status' => 'Ok',
                'message' => 'Property deleted successfully!',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     *  Property applications
     */
    public function applications(Property $property)
    {
        try {
            return response()->json([
                'status' => 'Ok',
                'data' => ApplicationResource::collection($property->applications)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     *  Property references
     */
    public function preferences(Property $property)
    {
        try {
            return response()->json([
                'status' => 'Ok',
                'data' => $property->preferences == null ? [] : new PreferenceResource($property->preferences)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function assignTenant(Property $property)
    {
        try {
            $data = request()->validate([
                'tenant_id' => 'required|numeric|exists:tenants,id'
            ]);

            $property->tenant_id = $data['tenant_id'];
            $property->save();

            return response()->json([
                'status' => 'Ok',
                'message' => 'Tenant assigned to property successfuly'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
