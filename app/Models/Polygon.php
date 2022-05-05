<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Polygon extends Model
{
    use HasFactory;

    protected $table = 'polygon';

    protected $fillable = [
        'parent_id',
        'depth',
        'lat',
        'lon',
        'radius',
        'done',
    ];
}
