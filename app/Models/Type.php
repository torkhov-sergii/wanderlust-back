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
        'title'
    ];

    public function polygons()
    {
        return $this->belongsToMany(Polygon::class, PolygonType::class, 'type_id', 'polygon_id');
    }
}
