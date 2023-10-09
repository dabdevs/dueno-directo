<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\VerificationRequest\CreateRequest;
use App\Http\Requests\Api\V1\VerificationRequest\UpdateRequest;
use App\Http\Resources\VerificationRequestResource;
use App\Models\Document;
use App\Models\Property;
use App\Models\Tenant;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class VerificationRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $verification_requests = VerificationRequest::paginate(10);

            return response()->json([
                'status' => 'OK',
                "data" => VerificationRequestResource::collection($verification_requests),
                'meta' => [
                    'current_page' => $verification_requests->currentPage(),
                    'from' => $verification_requests->firstItem(),
                    'last_page' => $verification_requests->lastPage(),
                    'path' => $verification_requests->path(),
                    'per_page' => $verification_requests->perPage(),
                    'to' => $verification_requests->lastItem(),
                    'total' => $verification_requests->total(),
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        try {
            DB::beginTransaction(); 

            // verification request's data
            $vr_data = $request->only(["type", "phone"]);

            if ($request->has('propertyId')) {
                $vr_data['property_id'] = $request->propertyId;
                $property = Property::findOrFail($request->propertyId);

                if ($property->verification_request != null) {
                    return response()->json([
                        'status' => 'OK',
                        'message' => 'Verification already requested'
                    ], 400);
                }
                $verification_request = $property->verification_request()->create($vr_data);
            }

            if ($request->has('tenantId')) {
                $vr_data['tenant_id'] = $request->tenantId;
                $tenant = Tenant::findOrFail($request->tenantId);

                if ($tenant->verification_request != null) {
                    return response()->json([
                        'status' => 'OK',
                        'message' => 'Verification already requested'
                    ], 400);
                }
                $verification_request = Tenant::findOrFail($request->tenantId)->verification_request()->create($vr_data);
            }

            // Creating documents
            $verification_request->documents()->create([
                'name' => Document::ID_BACK,
                'path' => $request->file('backId')->store('documents/ids')
            ]);

            $verification_request->documents()->create([
                'name' => Document::ID_FRONT,
                'path' => $request->file('frontId')->store('documents/ids')
            ]);

            DB::commit();

            return response()->json([
                'status' => 'OK',
                'message' => 'Verification request submited successfuly',
                'data' => new VerificationRequestResource($verification_request)
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
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
    public function show(VerificationRequest $verification_request)
    {
        try {
            return response()->json([
                'status' => 'OK',
                'data' => new VerificationRequestResource($verification_request)
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, VerificationRequest $verification_request)
    {
        try {
            $valid_data = $request->only(['phone', 'userId', 'status']);

            if ($request->has('backId')) {
                if (Storage::exists($verification_request->back_id)) {
                    Storage::delete($verification_request->back_id);
                }

                $valid_data['back_id'] = $request->file('backId')->store('documents/ids');
            }

            if ($request->has('frontId')) {
                if (Storage::exists($verification_request->front_id)) {
                    Storage::delete($verification_request->front_id);
                }
                $valid_data['front_id'] = $request->file('frontId')->store('documents/ids');
            }

            $verification_request->update($valid_data);

            return response()->json([
                'status' => 'OK',
                'message' => 'Verification request updated successfuly',
                'data' => new VerificationRequestResource($verification_request)
            ], 201);
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
    public function destroy(VerificationRequest $verification_request)
    {
        try {
            $verification_request->delete();

            return response()->json([
                'status' => 'OK',
                'message' => 'User deleted successfully!'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     *  Change verification's request status
     */
    public function changeStatus(VerificationRequest $verification_request, Request $request)
    {
        try {
            $data = $request->validate([
                'status' => ['required', 'string', Rule::in(['Pending', 'Approved', 'Rejected'])]
            ]); 

            $verification_request->status = $data['status'];
            $verification_request->save();

            return response()->json([
                'status' => 'OK',
                'message' => "Application $request->status successfuly" 
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
