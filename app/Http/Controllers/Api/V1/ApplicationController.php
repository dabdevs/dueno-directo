<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Application\createRequest;
use App\Http\Requests\Api\V1\Application\UpdateRequest;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\Property;
use App\Models\Tenant;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $applications = Application::paginate(10);

            return response()->json([
                "status" => "Ok",
                "data" => ApplicationResource::collection($applications),
                'meta' => [
                    'current_page' => $applications->currentPage(),
                    'from' => $applications->firstItem(),
                    'last_page' => $applications->lastPage(),
                    'path' => $applications->path(),
                    'per_page' => $applications->perPage(),
                    'to' => $applications->lastItem(),
                    'total' => $applications->total(),
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "Ok",
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
            $tenant = Tenant::findOrFail($request->tenant_id);

            // Validate if tenant has already applied for the property
            $application = Application::where([
                "tenant_id" => $tenant->id,
                "property_id" => $request->property_id
            ])->first();

            if ($application) {
                return response()->json([
                    'message' => 'You already applied for this property.'
                ], 400);
            }

            $application = Property::find($request->property_id)->applications()->create($request->validated());

            return response()->json([
                'status' => 'Ok',
                'data' => new ApplicationResource($application),
                'message' => 'Application created successfuly!'
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
    public function show(Application $application)
    {
        return response()->json([
            'data' => new ApplicationResource($application)
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
    public function update(UpdateRequest $request, Application $application)
    {
        try {
            $application->update($request->validated());

            return response()->json([
                'status' => 'Ok',
                'data' => new ApplicationResource($application)
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
    public function destroy(Application $application)
    {
        try {
            $application->delete();

            return response()->json([
                'status' => 'Ok',
                'message' => 'Application deleted successfuly'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
