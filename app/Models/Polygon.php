<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function PHPUnit\Framework\isNull;

class Polygon extends Model
{
    use HasFactory;

    protected $table = 'polygon';

    protected $fillable = [
        'root_polygon_id',
        'parent_id',
        'title',
        'depth',
        'lat',
        'lon',
        'radius',
        'disabled',
        'message',
        'created_at',
        'updated_at',
    ];

    public function types()
    {
        return $this->belongsToMany(Type::class, PolygonType::class, 'polygon_id', 'type_id')
            ->withPivot([
                'done',
            ])
            ->withTimestamps()
            ->using(PolygonType::class);
    }

    public function places()
    {
        return $this->hasMany(Place::class, 'root_polygon_id');
//            ->orWhereIn('polygon_id', $this->getSiblingPolygonsIds());
    }

//    public function getSiblingPolygonsIds()
//    {
//        $rootPolygonId = (isset($this->parent_id)) ? $this->parent_id : $this->id;
//
//        $polygonIds = Polygon::query()
//            ->where('parent_id', $rootPolygonId)
//            ->get()
//            ->pluck('id')
//            ->toArray();
//
//        $polygonIds[] = $rootPolygonId;
//
//        return $polygonIds;
//    }
}
