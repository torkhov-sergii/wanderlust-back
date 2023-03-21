<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $table = 'place';

    protected $fillable = [
        'root_polygon_id',
        'polygon_type_id',
        'polygon_id',
        'title',
        'place_id',
        'rating',
        'ratings_total',
        'types',
        'lat',
        'lon',
    ];

    protected $casts = [
        'types' => 'array',
    ];

    const EXCLUDE_TAGS = [
        'shop',
        'food',
        'store',
        'lodging',
        'health',
        'political',
        'parking',
        'hair_care',
        'post_office',
        'electrician',
        'finance',
        'gas_station',
        'travel_agency',
        'car_wash',
        'car_repair',
        'locksmith',
        'general_contractor',
        'veterinary_care',
        'roofing_contractor',
        'school',
        'local_government_office',
        'plumber',
        'bar',
        'insurance_agency',
        'moving_company',
        'police',
        'lawyer',
        'cemetery',
        'casino',
        'library',
        'art_gallery',
        'transit_station',
        'premise',
        'real_estate_agency',
        'beauty_salon',
        'painter',
        'fire_station',
        'funeral_home',
        'laundry',
        'stadium',
        'bowling_alley',
        'movie_theater',
        'embassy',
        'hindu_temple',
        'airport',
        'car_rental',
        'storage',
        'university',
    ];

    public function polygon()
    {
        return $this->belongsTo(Polygon::class);
    }

    public function polygon_type()
    {
        return $this->belongsTo(Type::class);
    }

    // exclude "establishment" type
    public function getTypes()
    {
        $types = $this->types;

        if (($key = array_search('establishment', $types)) !== false) {
            unset($types[$key]);
        }

        return $types;
    }
}
