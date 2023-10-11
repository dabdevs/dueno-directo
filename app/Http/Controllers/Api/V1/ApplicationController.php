<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Application\createRequest;
use App\Http\Requests\Api\V1\Application\UpdateRequest;
use App\Http\Resources\PropertyApplicationResource;
use App\Models\Property;
use App\Models\PropertyApplication;
use App\Models\Tenant;
use App\Models\User;
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
            $user = auth()->user();
            $applications = $user->role == 'admin' ? PropertyApplication::paginate(10) : $user->tenant->applications->paginate(10);

            return response()->json([
                'status' => 'OK',
                "data" => PropertyApplicationResource::collection($applications),
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

            if (!$property->isPublished()) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'This property is not published.'
                ], 400);
            }

            $user = User::findOrFail($request->user_id);

            // Validate if user has already applied for the property
            $application = PropertyApplication::where([
                "user_id" => $user->id,
                "property_id" => $request->property_id
            ])->first();

            if ($application) {
                return response()->json([
                    'status' => 'OK',
                    'data' => new PropertyApplicationResource($application)
                ]);
            }

            $application = $property->applications()->create($request->validated());

            return response()->json([
                'status' => 'OK',
                'data' => new PropertyApplicationResource($application),
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
    public function show(PropertyApplication $application)
    {
        try {
            if (!$this->_authorize($application)) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Unauthorized'
                ], 403);
            }

            return response()->json([
                'status' => 'OK',
                'data' => new PropertyApplicationResource($application)
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
    public function update(UpdateRequest $request, PropertyApplication $application)
    {
        try {
            if (!$this->_authorize($application)) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Unauthorized'
                ], 403);
            }

            $application->update($request->validated());

            return response()->json([
                'status' => 'OK',
                'data' => new PropertyApplicationResource($application)
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
    public function destroy(PropertyApplication $application)
    {
        try {
            if (!$this->_authorize($application)) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Unauthorized'
                ], 403);
            }

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
    public function changeStatus(PropertyApplication $application, Request $request)
    {
        try {
            if (!$this->_authorize($application)) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Unauthorized'
                ], 403);
            }

            $request->validate([
                'status' => ['required', 'string', Rule::in(['Pending', 'Approved', 'Rejected'])]
            ]);

            $application->status = $request->status;
            $application->save();

            return response()->json([
                'status' => 'OK',
                'message' => 'Application updated successfuly',
                'data' => new PropertyApplicationResource($application)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    private function _authorize(PropertyApplication $application)
    {
        if (auth()->id() != $application->property->user_id && auth()->user()->role != User::ROLE_ADMIN) {
            return false;
        }

        return true;
    }
}
