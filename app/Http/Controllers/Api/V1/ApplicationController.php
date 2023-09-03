<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Application\createRequest;
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
            return response()->json([
                "status" => "Success",
                "applications" => ApplicationResource::collection(Application::all())
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                "status" => "Success",
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
            // Validate if tenant exists
            $tenant = Tenant::findOrFail($request->tenant_id);

            $application = Application::where([
                "tenant_id" => $tenant->id,
                "property_id" => $request->property_id
            ])->first();

            if ($application) {
                return response()->json([
                    'message' => 'You already applied for this property'
                ], 400);
            }

            $application = Property::findOrFail($request->property_id)->applications()->create($request->all());

            return response()->json([
                'status' => 'Success',
                'application' => new ApplicationResource($application),
                'message' => 'Application created successfuly!'
            ], 200);
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
        //
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
