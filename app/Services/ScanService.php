<?php

namespace App\Services;

use App\Models\Polygon;
use Illuminate\Database\Eloquent\Collection;

class ScanService
{
    public function allPolygons(): Collection
    {
        return Polygon::query()
            ->get();
    }
}
