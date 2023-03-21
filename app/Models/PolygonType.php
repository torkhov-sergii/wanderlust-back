<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PolygonType extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'polygon_id',
        'type_id',
        'done',
        'added_places',
        'max_ratings_total',
        'message',
        'created_at',
        'updated_at',
    ];
}
