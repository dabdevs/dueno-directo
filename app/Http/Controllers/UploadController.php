<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\V1\Upload\PropertyPhotosRequest;
use App\Http\Resources\PropertyResource;
use App\Models\Photo;
use App\Models\Property;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function propertyPhotos(PropertyPhotosRequest $request)
    {
        try {
            DB::beginTransaction();

            $property = Property::findOrFail($request->property_id);

            if ($request->has('deleted_photos')) {
                // Ids of photos to be deleted 
                $deleted_photos = $request->deleted_photos;

                foreach ($deleted_photos as $id) {
                    $photo = Photo::findOrFail($id);
                    
                    // Define the photo directory
                    $photo_directory = "images/properties/photos/$property->id/$photo->path";
                    $photo->delete(); 

                    if (file_exists($photo_directory)) {
                        // Delete the directory and its contents
                        Storage::deleteDirectory($photo_directory); 
                    } 
                }
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
}
