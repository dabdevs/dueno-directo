<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Property\CreateRequest;
use App\Http\Requests\Api\V1\Property\UpdateRequest;
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
            $properties = Property::all();

            return response()->json([
                "properties" => PropertyResource::collection($properties)
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'message' => 'Internal error!'
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        try {
            $user = User::findOrFail($request->user_id);

            // If user's role is not owner 
            if ($user->role != User::ROLE_OWNER)
                return response()->json([
                    'message' => 'Invalid user.'
                ], 401);

            $property = $user->properties()->create($request->all());

            return response()->json([
                'status' => 'Success',
                'message' => 'Property created successfully!',
                'property' => new PropertyResource($property)
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Internal error!'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $property = Property::find($id);

            if (!$property)
                return response()->json([
                    'message' => 'Property not found',
                ], 404);

            return response()->json([
                'status' => 'Success',
                'property' => new PropertyResource($property)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Internal error!'
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        try {
            $property = Property::find($id);

            // If the property is not found
            if (!$property) {
                return response()->json([
                    'status' => 'Success',
                    'message' => 'Property not found!'
                ], 404);
            }

            $property->update($request->all());

            return response()->json([
                'status' => 'Success',
                'message' => 'Property updated successfully!',
                'property' => new PropertyResource($property)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Internal error!'
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
                    'status' => 'Success',
                    'message' => 'Property not found!'
                ], 404);
            }

            $property->delete();

            return response()->json([
                'status' => 'Success',
                'message' => 'Property deleted successfully!',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Internal error!'
            ], 500);
        }
    }
}
