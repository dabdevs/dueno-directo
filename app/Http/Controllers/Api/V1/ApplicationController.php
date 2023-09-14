<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Application\createRequest;
use App\Http\Requests\Api\V1\Application\UpdateRequest;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\Property;
use App\Models\Tenant;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApplicationController extends Controller
{
    /**
     * Display all applications.
     *
     */
    public function index()
    {
        try {
            $user = auth()->user(); dd($user);
            $applications = $user->role == 'admin' ? Application::paginate(10) : $user->tenant->applications->paginate(10);

            return response()->json([
                'status' => 'OK',
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
                'status' => 'OK',
                "message" => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Store new application
     *
     */
    public function store(CreateRequest $request)
    {
        try {
            $property = Property::findOrFail($request->property_id);

            if (!$property->isAvailable()) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'The property is not available.'
                ], 400);
            }

            $tenant = Tenant::findOrFail($request->tenant_id);

            // Validate if tenant has already applied for the property
            $application = Application::where([
                "tenant_id" => $tenant->id,
                "property_id" => $request->property_id
            ])->first();

            if ($application) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'You already applied for this property.'
                ], 400);
            }

            $application = $property->applications()->create($request->validated());

            return response()->json([
                'status' => 'OK',
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
     * Show application
     *
     */
    public function show(Application $application)
    {
        try {
            $this->validateUserAction($application);

            return response()->json([
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
     * Update application
     *
     */
    public function update(UpdateRequest $request, Application $application)
    {
        try {
            $this->validateUserAction($application, 'update applications');
            $application->update($request->validated());

            return response()->json([
                'status' => 'OK',
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
     * Delete application
     */
    public function destroy(Application $application)
    {
        try {
            $this->validateUserAction($application);
            $application->delete();

            return response()->json([
                'status' => 'OK',
                'message' => 'Application deleted successfuly'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     *  Change application status
     */
    public function changeStatus(Application $application, Request $request)
    {
        try {
            $this->validateUserAction($application);

            $data = $request->validate([
                'status' => ['required', 'string', Rule::in(['pending', 'accepted', 'rejected'])]
            ]);

            $application->status = $data['status'];
            $application->save();

            return response()->json([
                'status' => 'OK',
                'message' => $data['status'] === 'accepted' ? 'Application accepted successfuly' : 'Application rejected successfuly'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    private function validateUserAction(Application $application = null, string $permission = null)
    {
        $user = auth()->user();

        if ($permission != null && !$user->can($permission)) {
            throw new Exception('Forbidden');
        }

        if ($application != null) {
            // Validate the user
            if ($user->id != $application->tenant_id || $user->role != User::ROLE_ADMIN) {
                throw new Exception('Forbidden');
            }
        }
    }
}
