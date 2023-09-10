<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Tenant\CreateRequest;
use App\Http\Requests\Api\V1\Tenant\UpdateRequest;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\TenantResource;
use App\Models\Tenant;
use App\Models\User;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $tenants = Tenant::paginate(10);

            return response()->json([
                "status" => "Ok",
                "data" => TenantResource::collection($tenants),
                'meta' => [
                    'current_page' => $tenants->currentPage(),
                    'from' => $tenants->firstItem(),
                    'last_page' => $tenants->lastPage(),
                    'path' => $tenants->path(),
                    'per_page' => $tenants->perPage(),
                    'to' => $tenants->lastItem(),
                    'total' => $tenants->total(),
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
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
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        try {
            $user = User::find($request->user_id);

            if ($user->role != User::ROLE_TENANT) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'User is not a tenant.'
                ], 400);
            }

            if ($user->profile) {
                return response()->json([
                    'message' => 'Profile already created.',
                    'data' => $user->profile
                ]);
            }

            $tenant = $user->tenant()->firstOrCreate($request->validated());

            return response()->json([
                'status' => 'Ok',
                'message' => 'Tenant created successfuly!',
                'data' => new TenantResource($tenant)
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
    public function show(Tenant $tenant)
    {
        try {
            return response()->json([
                'status' => 'Ok',
                'data' => new TenantResource($tenant)
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
     * Update tenant.
     *
     */
    public function update(UpdateRequest $request, Tenant $tenant)
    {
        try {
            $tenant->update($request->validated());

            return response()->json([
                'status' => 'Ok',
                'message' => 'Tenant updated successfully!',
                'data' => new TenantResource($tenant)
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
    public function destroy(Tenant $tenant)
    {
        try {
            $tenant->delete();

            return response()->json([
                'status' => 'Ok',
                'message' => 'Tenant deleted successfully!'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function applications(Tenant $tenant)
    {
        try {
            return response()->json([
                'status' => 'Ok',
                'data' => ApplicationResource::collection($tenant->applications)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
