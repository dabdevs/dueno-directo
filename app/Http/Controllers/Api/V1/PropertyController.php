<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Property\CreateRequest;
use App\Http\Requests\Api\V1\Property\UpdateRequest;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\PreferenceResource;
use App\Http\Resources\PropertyResource;
use App\Http\Resources\TenantResource;
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
                'status' => 'OK',
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
                'status' => 'OK',
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
                'status' => 'OK',
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
                'status' => 'OK',
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
                    'status' => 'OK',
                    'message' => 'Property not found!'
                ], 404);
            }

            $property->delete();

            return response()->json([
                'status' => 'OK',
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
                'status' => 'OK',
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
                'status' => 'OK',
                'data' => $property->preferences == null ? [] : new PreferenceResource($property->preferences)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Assign the tenant to a property
     */
    public function assignTenant(Property $property)
    {
        try {
            $data = request()->validate([
                'tenant_id' => 'required|numeric|exists:tenants,id'
            ]);

            $property->tenant_id = $data['tenant_id'];
            $property->save();

            return response()->json([
                'status' => 'OK',
                'message' => 'Tenant assigned to property successfuly'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Get the tenant of a property
     */
    public function tenant(Property $property)
    {
        try {
            return response()->json([
                'status' => 'OK',
                'data' => $property->tenant == null ? [] : new TenantResource($property->tenant)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function search(Request $request)
    {
        try {
            $query = Property::query();

            if ($request->has('title')) {
                $query->where('title', 'like', '%' . $request->title . '%');
            }

            if ($request->has('min_price')) {
                $query->where('price', '>=', $request->min_price);
            }

            if ($request->has('max_price')) {
                $query->where('price', '<=', $request->max_price);
            }

            if ($request->has('lease_term')) {
                $query->where('lease_term', $request->lease_term);
            }

            if ($request->has('bedrooms')) {
                $query->where('bedrooms', $request->bedrooms);
            }

            if ($request->has('bathrooms')) {
                $query->where('bathrooms', $request->bathrooms);
            }

            if ($request->has('min_area')) {
                $query->where('area', '>=', $request->min_area);
            }

            if ($request->has('max_area')) {
                $query->where('area', '<=', $request->max_area);
            }

            if ($request->has('location')) {
                $query->where('location', $request->location);
            }

            $properties = $query->paginate(20);

            return response()->json([
                'status' => 'OK',
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
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
