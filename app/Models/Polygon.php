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
        'title',
        'depth',
        'lat',
        'lon',
        'radius',
        'disabled',
    ];

    public function types()
    {
        return $this->belongsToMany(Type::class, PolygonType::class, 'polygon_id', 'type_id')
            ->withPivot([
                'done',
            ])
            ->using(PolygonType::class);
    }
}
