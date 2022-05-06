<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Places extends Model
{
    use HasFactory;

    protected $table = 'places';

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
