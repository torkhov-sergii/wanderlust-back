<?php

namespace App\Http\Controllers;

use App\Services\ScanService;

class ScanController extends Controller
{
    protected ScanService $scanService;

    public function __construct(ScanService $scanService)
    {
        $this->scanService = $scanService;
    }

    public function scan()
    {
        return $this->scanService->allPolygons();
    }
}
