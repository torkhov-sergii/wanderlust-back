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
        'user_rating',
        'types',
        'lat',
        'lon',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'types' => 'array',
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
