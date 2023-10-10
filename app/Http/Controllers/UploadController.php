<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\V1\Upload\PropertyDeletePhotosRequest;
use App\Http\Requests\Api\V1\Upload\PropertyUploadPhotosRequest;
use App\Http\Resources\PropertyResource;
use App\Models\Photo;
use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function propertyUploadPhotos(PropertyUploadPhotosRequest $request, Property $property)
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
                $this->deletePhotos($request->deleted_photos, $property->id);
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
                'message' => 'Photos uploaded successfuly',
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

    public function PropertydeletePhotos(PropertyDeletePhotosRequest $request, Property $property) 
    {
        try {
            DB::beginTransaction();

            if ($request->has('deleted_photos')) {
                $this->deletePhotos($request->deleted_photos, $property->id);
            }

            DB::commit();

            return response()->json([
                'status' => 'OK',
                'message' => 'Photos deleted successfuly'
            ]);
        } catch (\Throwable $th) {
            DB::rollback();

            return response()->json([
                'status' => 'Error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    private function deletePhotos($photos, $property_id=null)
    {
        if (count($photos) > 0) {
            foreach ($photos as $id) {
                $photo = Photo::findOrFail($id);

                // Define the photo directory
                $photo_directory = "images/properties/photos/$property_id/$photo->path";
                $photo->delete();

                if (file_exists($photo_directory)) {
                    // Delete the directory and its contents
                    Storage::deleteDirectory($photo_directory);
                }
            }
        }
    }
}
