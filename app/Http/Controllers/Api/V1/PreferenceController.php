<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Preference\CreateRequest;
use App\Http\Requests\Api\V1\Preference\UpdateRequest;
use App\Http\Resources\PropertyPreferenceResource;
use App\Models\Preference;
use App\Models\Property;

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
                "data" => PropertyPreferenceResource::collection(Preference::all())
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
            $property = Property::find($request->property_id);
            if (!$property) {
                return response()->json([
                    'message' => 'Property does not exist.'
                ], 404);
            }

            // Create preference
            $preference = $property->preferences()->firstOrCreate($request->validated());

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
    public function show(Preference $preference)
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
    public function update(UpdateRequest $request, Preference $preference)
    {
        try {
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
    public function destroy(Preference $preference)
    {
        try {
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
