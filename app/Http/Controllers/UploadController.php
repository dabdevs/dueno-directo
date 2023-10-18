<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\V1\Upload\PropertyDeletePhotosRequest;
use App\Http\Requests\Api\V1\Upload\PropertyUploadPhotosRequest;
use App\Http\Requests\Api\V1\Upload\UserAvatarRequest;
use App\Http\Resources\PropertyResource;
use App\Models\Photo;
use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UploadController extends Controller
{
    /**
     * Upload photos for a property
     */
    public function uploadPropertyPhotos(PropertyUploadPhotosRequest $request, Property $property)
    {
        try {
            if ($property->owner->id != auth()->id() && auth()->user()->role != User::ROLE_ADMIN) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Forbidden'
                ], 403);
            }

            DB::beginTransaction();

            if ($request->has('deleted_photos')) {
                $this->deletePhotos($request->deleted_photos);
            }

            // Retrieve the uploaded files
            $photos = $request->file('photos');

            // Uploading photos
            if ($photos) {
                foreach ($photos as $photo) {
                    $path = $photo->store('images/properties/photos/' . $property->id);
                    $property->photos()->create(['path' => $path, 'type' => $request->type]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => 'OK',
                'message' => 'Photos uploaded successfully',
                'data' => new PropertyResource($property)
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Delete photos from property
     */
    public function deletePropertyPhotos(PropertyDeletePhotosRequest $request, Property $property)
    {
        try {
            DB::beginTransaction();

            if ($request->has('deleted_photos')) {
                $this->deletePhotos($request->deleted_photos);
            }

            DB::commit();

            return response()->json([
                'status' => 'OK',
                'message' => 'Photos deleted successfully'
            ]);
        } catch (\Throwable $th) {
            DB::rollback();

            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     *  Delete photos from both database and storage
     */
    private function deletePhotos($photos)
    {
        if (count($photos) > 0) {
            foreach ($photos as $id) {
                $photo = Photo::findOrFail($id);
                $directory = storage_path('app/' . $photo->path);

                if (file_exists($directory)) {
                    unlink($directory);
                    $photo->delete();
                }
            }
        }
    }

    /**
     *  Upload an avatar for user
     */
    public function userAvatar(UserAvatarRequest $request)
    {
        try {
            $user = User::find(auth()->id());

            // If the avatar is being replaced
            if ($user->avatar) {
                $directory = storage_path('app/' . $user->avatar);

                if (file_exists($directory)) {
                    unlink($directory);
                }
            }

            $path = $request->file('avatar')->store('images/users/avatars/' . $user->id);
            $user->avatar = $path;
            $user->save();

            return response()->json([
                'status' => 'OK',
                'message' => 'Avatar uploaded successfully.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
