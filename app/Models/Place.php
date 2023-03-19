<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $table = 'place';

    protected $fillable = [
        'name',
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

}
