<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Tenant\CreateRequest;
use App\Http\Requests\Api\V1\Tenant\UpdateRequest;
use App\Http\Requests\Api\V1\VerificationRequest\CreateRequest as VerificationCreateRequest;
use App\Http\Resources\PropertyApplicationResource;
use App\Http\Resources\TenantResource;
use App\Http\Resources\UserResource;
use App\Models\Document;
use App\Models\Property;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
            $users = User::with('preferences')->whereRole('tenant')->paginate(env('PAGINATION'));

            return response()->json([
                'status' => 'OK',
                "data" => UserResource::collection($users),
                'meta' => [
                    'current_page' => $users->currentPage(),
                    'from' => $users->firstItem(),
                    'last_page' => $users->lastPage(),
                    'path' => $users->path(),
                    'per_page' => $users->perPage(),
                    'to' => $users->lastItem(),
                    'total' => $users->total(),
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
                'status' => 'OK',
                'message' => 'Tenant created successfully!',
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
                'status' => 'OK',
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
                'status' => 'OK',
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
                'status' => 'OK',
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
                'status' => 'OK',
                'data' => PropertyApplicationResource::collection($tenant->applications)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function apply(Tenant $tenant, Property $property)
    {
        try {
            $tenant->apply($property);

            return response()->json([
                'status' => 'OK',
                'message' => 'Application submited successfully.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function requestVerification(Tenant $tenant, VerificationCreateRequest $request)
    {
        try {
            DB::beginTransaction();

            // verification request's data
            $vr_data = $request->only(["type", "phone"]);

            if ($tenant->verification_request != null) {
                return response()->json([
                    'status' => 'OK',
                    'message' => 'Verification already requested'
                ], 400);
            }

            $verification_request = $tenant->verification_request()->create($vr_data);

            // Creating documents
            $verification_request->documents()->create([
                'name' => Document::ID_BACK,
                'path' => $request->file('backId')->store('images/ids')
            ]);

            $verification_request->documents()->create([
                'name' => Document::ID_FRONT,
                'path' => $request->file('frontId')->store('images/ids')
            ]);

            DB::commit();

            return response()->json([
                'status' => 'OK',
                'message' => 'Verification request submited successfully.'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
