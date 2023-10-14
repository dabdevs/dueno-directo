<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\VerificationRequest\CreateRequest;
use App\Http\Requests\Api\V1\VerificationRequest\UpdateRequest;
use App\Http\Resources\VerificationRequestResource;
use App\Models\Document;
use App\Models\Property;
use App\Models\User;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

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
            $verification_requests = auth()->user()->role == 'admin' ? VerificationRequest::paginate(20) :
                VerificationRequest::whereHas('property', function ($query) {
                    $query->where('user_id', auth()->id());
                })->paginate(env('PAGINATION'));

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

            if ($request->has('property_id') && $request->type == 'property') {
                $property = Property::findOrFail($request->property_id);

                if ($property->verification_request != null) {
                    return response()->json([
                        'status' => 'OK',
                        'message' => 'Verification request already submited'
                    ], 400);
                }
                $verification_request = $property->verification_request()->create($request->validated());
            }

            if ($request->has('user_id') && $request->type == 'user') {
                $user = User::findOrFail($request->user_id);

                if ($user->verification_request != null) {
                    return response()->json([
                        'status' => 'OK',
                        'message' => 'Verification request already submited'
                    ], 400);
                }
                $verification_request = $user->verification_request()->create($request->validated());
            }

            // Creating documents
            $verification_request->documents()->create([
                [
                    'name' => Document::ID_BACK,
                    'path' => $request->file('back_id')->store('documents/ids')
                ],
                [
                    'name' => Document::ID_FRONT,
                    'path' => $request->file('front_id')->store('documents/ids')
                ]
            ]);

            DB::commit();

            return response()->json([
                'status' => 'OK',
                'message' => 'Verification request submited successfully',
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
            if (!$this->_authorize($verification_request)) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Forbidden'
                ], 403);
            }

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
            if (!$this->_authorize($verification_request)) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Forbidden'
                ], 403);
            }

            $valid_data = $request->all();

            if ($request->has('back_id')) {
                if (Storage::exists($verification_request->back_id)) {
                    Storage::delete($verification_request->back_id);
                }

                $valid_data['back_id'] = $request->file('back_id')->store('documents/ids');
            }

            if ($request->has('front_id')) {
                if (Storage::exists($verification_request->front_id)) {
                    Storage::delete($verification_request->front_id);
                }
                $valid_data['front_id'] = $request->file('front_id')->store('documents/ids');
            }

            $verification_request->update($valid_data);

            return response()->json([
                'status' => 'OK',
                'message' => 'Verification request updated successfully',
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
            if (!$this->_authorize($verification_request)) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Forbidden'
                ], 403);
            }

            $verification_request->delete();

            return response()->json([
                'status' => 'OK',
                'message' => 'Verification request deleted successfully!'
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
            if (!$this->_authorize($verification_request)) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Forbidden'
                ], 403);
            }

            $data = $request->validate([
                'status' => ['required', 'string', Rule::in(['Pending', 'Approved', 'Rejected'])]
            ]);

            $verification_request->status = $data['status'];
            $verification_request->save();

            return response()->json([
                'status' => 'OK',
                'message' => "Application " . Str::lower($request->status) . " successfully"
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    private function _authorize(VerificationRequest $verification_request)
    {
        $user_id = $verification_request->type == 'user' ? $verification_request->user_id : $verification_request->property->user_id;

        if (auth()->id() != $user_id && auth()->user()->role != User::ROLE_ADMIN) {
            return false;
        }

        return true;
    }
}
