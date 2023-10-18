<?php

namespace App\Services;

use App\Models\User;
use App\Models\Property;

class PropertyMatcher
{
    public function matchProperties(User $user)
    {
        // Get user preferences (e.g., location, price range, size, amenities)
        $location = $user->location;
        $priceRange = $user->price_range;
        $size = $user->size;
        $amenities = $user->amenities;

        // Use database indexes to speed up queries
        $matchingProperties = Property::where('location', $location)
            ->orWhere('location', 'LIKE', '%' . $location . '%')
            ->whereBetween('rental_price', $priceRange)
            ->where('size', '>=', $size)
            ->whereIn('amenities', $amenities)
            ->get();

        // Implement caching for frequently used queries
        $matchingProperties = cache()->remember('user_' . $user->id . '_matching_properties', now()->addHours(12), function () use ($location, $priceRange, $size, $amenities) {
            return Property::where('location', $location)
                ->orWhere('location', 'LIKE', '%' . $location . '%')
                ->whereBetween('rental_price', $priceRange)
                ->where('size', '>=', $size)
                ->whereIn('amenities', $amenities)
                ->get();
        });

        return $matchingProperties;
    }
}