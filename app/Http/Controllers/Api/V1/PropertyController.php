<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Property\CreateRequest;
use App\Http\Requests\Api\V1\Property\UpdateRequest;
use App\Http\Resources\PropertyApplicationResource;
use App\Http\Resources\PreferenceResource;
use App\Http\Resources\PropertyResource;
use App\Http\Resources\TenantResource;
use App\Models\Property;
use App\Models\Tenant;
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
            $properties = auth()->user()->role == 'admin' ? Property::with('photos')->paginate(20) : Property::where('user_id', auth()->id())->paginate(20);

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
            throw $th;
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Create a property.
     *
     */
    public function store(CreateRequest $request)
    {
        try {
            $user_id = $request->has('user_id') ? $request->user_id : auth()->id();

            // Get the user
            $user = User::findOrFail($user_id);

            if (!$user->hasRole(User::ROLE_OWNER)) {
                return response()->json(['message' => 'User is not an owner'], 403);
            }

            $data = $request->validated();
            $data['slug'] = str_replace('', '-', $request->title);

            $property = $user->properties()->create($data);

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
            throw $th;
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(UpdateRequest $request, Property $property)
    {
        try {
            if (!$this->_authorize($property)) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Unauthorized'
                ], 403);
            }

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
     * Remove the specified resource
     *
     */
    public function destroy(Property $property)
    {
        try {
            if (!$this->_authorize($property)) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Unauthorized'
                ], 403);
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
            $this->validateUserAction($property);

            return response()->json([
                'status' => 'OK',
                'data' => PropertyApplicationResource::collection($property->applications)
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
            if (!$this->_authorize($property)) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Unauthorized'
                ], 403);
            }

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
            if (!$this->_authorize($property)) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Unauthorized'
                ], 403);
            }

            $data = request()->validate([
                'user_id' => 'required|numeric|exists:users,id'
            ]);

            $user = User::findOrFail($data['user_id']);

            if ($user->role != User::ROLE_TENANT) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'User is not a tenant'
                ], 403);
            }

            $property->assignTenant($user);

            return response()->json([
                'status' => 'OK',
                'message' => 'Tenant assigned to property successfuly',
                'data' => new PropertyResource($property)
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Get the tenant of a property
     */
    public function getTenant(Property $property)
    {
        try {
            if (!$this->_authorize($property)) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Unauthorized'
                ], 403);
            }

            return response()->json([
                'status' => 'OK',
                'data' => $property->tenant == null ? null : new TenantResource($property->tenant)
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

            if ($request->has('keyword')) {
                $query->where('title', 'like', '%' . $request->keyword . '%');
                $query->orWhere('description', 'like', '%' . $request->keyword . '%');
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
                $query->where('location', 'like', '%' . $request->location . '%');
            }

            if ($request->has('negotiable')) {
                $query->where('negotiable', $request->negotiable);
            }

            if ($request->has('order')) {
                $query->orderBy($request->order);
            }

            if ($request->has('status')) {
                $query->whereStatus($request->status);
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

    public function changeStatus(Request $request, Property $property)
    {
        try {
            if (!$this->_authorize($property)) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Unauthorized'
                ], 403);
            }

            $property->status = $request->status;
            $property->save();

            return response()->json([
                'status' => 'OK',
                'message' => 'Status changed successfuly',
                'data' => new PropertyResource($property)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    private function _authorize(Property $property)
    {
        if (auth()->id() != $property->user_id && auth()->user()->role != User::ROLE_ADMIN) {
            return false;
        }

        return true;
    }
}
