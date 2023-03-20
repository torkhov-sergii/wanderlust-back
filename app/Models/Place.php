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

    const EXCLUDE_TAGS = ['shop', 'food', 'store', 'lodging', 'health', 'political', 'parking', 'hair_care', 'post_office', 'electrician'];

    public function polygon()
    {
        return $this->belongsTo(Polygon::class);
    }

    public function polygon_type()
    {
        return $this->belongsTo(Type::class);
    }
}
