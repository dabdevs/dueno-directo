<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Property\CreateRequest;
use App\Http\Resources\OwnerResource;
use App\Http\Resources\PropertyResource;
use App\Models\User;
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
        $owners = User::whereRole('owner')->get();

        return response()->json([
            'status' => 'OK',
            'data' => OwnerResource::collection($owners)
        ]);
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
    public function store()
    {
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

    public function myProperties()
    {
        try {
            return response()->json([
                'status' => 'OK',
                'data' => PropertyResource::collection(auth()->user()->properties)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function createProperty(CreateRequest $request)
    {
        try {
            $user = User::findOrFail(auth()->id());

            $data = $request->validated();
            $data['slug'] = str_replace('', '-', $request->title);

            $property = $user->properties()->create($data);

            return response()->json([
                'status' => 'OK',
                'message' => 'Property created successfully',
                'data' => new PropertyResource($property)
            ], 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
