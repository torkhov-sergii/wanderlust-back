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
        'parent_id',
        'title',
        'depth',
        'lat',
        'lon',
        'radius',
        'disabled',
        'message',
    ];

    public function types()
    {
        return $this->belongsToMany(Type::class, PolygonType::class, 'polygon_id', 'type_id')
            ->withPivot([
                'done',
            ])
            ->using(PolygonType::class);
    }

    public function places()
    {
        return $this->hasMany(Place::class)
            ->orWhereIn('polygon_id', $this->getSiblingPolygonsIds());
    }

    private function getSiblingPolygonsIds()
    {
        $rootPolygonId = (isset($this->parent_id)) ? $this->parent_id : $this->id;

        $polygonIds = Polygon::query()
            ->where('parent_id', $rootPolygonId)
            ->get()
            ->pluck('id')
            ->toArray();

        $polygonIds[] = $rootPolygonId;

        return $polygonIds;
    }
}
