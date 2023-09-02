<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Tenant\CreateRequest;
use App\Http\Requests\Api\V1\Tenant\UpdateRequest;
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
        return response()->json([
            'status' => 'Success',
            'tenants' => TenantResource::collection(Tenant::all())
        ]);
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
                    'message' => 'User is not a tenant.'
                ], 400);
            }

            if ($user->profile) {
                return response()->json([
                    'message' => 'Profile already created.',
                    'profile' => $user->profile
                ]);
            }

            $tenant = $user->tenant()->firstOrCreate($request->all());

            return response()->json([
                'status' => 'Success',
                'message' => 'Tenant created successfuly!',
                'tenant' => new TenantResource($tenant)
            ], 201);
        } catch (\Throwable $th) {
            //throw $th;
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
            $tenant = Tenant::find($id);

            // If the tenant is not found
            if (!$tenant) {
                return response()->json([
                    'status' => 'Success',
                    'message' => 'Tenant not found!'
                ], 404);
            }

            return response()->json([
                'status' => 'Success',
                'tentant' => new TenantResource($tenant)
            ]);
        } catch (\Throwable $th) {
            //throw $th;
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
            $tenant = Tenant::find($id);

            // If the tenant is not found
            if (!$tenant) {
                return response()->json([
                    'status' => 'Success',
                    'message' => 'Tenant not found!'
                ], 404);
            }

            $tenant->update($request->all());

            return response()->json([
                'status' => 'Success',
                'message' => 'Tenant updated successfully!',
                'tenant' => new TenantResource($tenant)
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
            $tenant = Tenant::find($id);

            // If the tenant is not found
            if (!$tenant) {
                return response()->json([
                    'status' => 'Success',
                    'message' => 'Tenant not found!'
                ], 404);
            }

            $tenant->delete();

            return response()->json([
                'status' => 'Success',
                'message' => 'Tenant deleted successfully!'
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'status' => 'Error',
                'message' => 'Internal error!'
            ], 500);
        }
    }
}
