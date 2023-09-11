<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\VerificationRequest\CreateRequest;
use App\Http\Requests\Api\V1\VerificationRequest\UpdateRequest;
use App\Http\Resources\VerificationRequestResource;
use App\Models\User;
use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            $user = User::findOrFail($request->userId); 

            if ($user->verification_request != null) {
                return response()->json([
                    'status' => 'OK',
                    'message' => 'Validation already requested'
                ], 400);
            }

            $back_id_path = $request->file('back_id')->store('images/ids');
            $front_id_path = $request->file('front_id')->store('images/ids');

            $verification_request = $user->verification_request()->create([
                "back_id" => $back_id_path,
                "front_id" => $front_id_path,
                "phone" => $request->phone
            ]);

            return response()->json([
                'status' => 'OK',
                'message' => 'Verification request submited successfuly',
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

                $valid_data['back_id'] = $request->file('backId')->store('images/ids');
            }

            if ($request->has('frontId')) {
                if (Storage::exists($verification_request->front_id)) {
                    Storage::delete($verification_request->front_id);
                }
                $valid_data['front_id'] = $request->file('frontId')->store('images/ids');
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
}
