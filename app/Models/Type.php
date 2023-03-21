<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $table = 'type';

    protected $fillable = [
        'place_id',
        'title',
        'created_at',
        'updated_at',
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
        'courthouse',
        'taxi_stand',
        'night_club',
    ];

    public function polygons()
    {
        return $this->belongsToMany(Polygon::class, PolygonType::class, 'type_id', 'polygon_id');
    }
}
