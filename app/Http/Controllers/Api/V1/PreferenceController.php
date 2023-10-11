<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Preference\CreateRequest;
use App\Http\Requests\Api\V1\Preference\UpdateRequest;
use App\Http\Resources\PropertyPreferenceResource;
use App\Http\Resources\UserResource;
use App\Models\Property;
use App\Models\PropertyPreference;
use App\Models\User;

class PreferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return response()->json([
                'status' => 'OK',
                "data" => PropertyPreferenceResource::collection(PropertyPreference::all())
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'OK',
                "message" => $th->getMessage()
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
    public function store(createRequest $request)
    {
        try {
            // Validate if property exists
            if ($request->has('property_id')) {
                $preference = Property::find($request->property_id)->preferences()->firstOrNew($request->validated());
            } else {
                $data = $request->validated();
                $data['occupation'] = array($request->occupation);
                $preference = User::find($request->user_id)->preferences()->firstOrNew($data);
            }

            return response()->json([
                'status' => 'OK',
                'data' => new PropertyPreferenceResource($preference),
                'message' => 'Preference created successfuly!'
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PropertyPreference $preference)
    {
        return response()->json([
            'data' => new PropertyPreferenceResource($preference)
        ]);
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
    public function update(UpdateRequest $request, PropertyPreference $preference)
    {
        try {
            if (auth()->id() != $preference->property->user_id && auth()->user()->role != User::ROLE_ADMIN) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Forbidden'
                ], 403);
            }

            $preference->update($request->validated());

            return response()->json([
                'status' => 'OK',
                'data' => new PropertyPreferenceResource($preference)
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
    public function destroy(PropertyPreference $preference)
    {
        try {
            if (auth()->id() != $preference->property->user_id && auth()->user()->role != User::ROLE_ADMIN) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Forbidden'
                ], 403);
            }

            $preference->delete();

            return response()->json([
                'status' => 'OK',
                'message' => 'Preference deleted successfuly'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
