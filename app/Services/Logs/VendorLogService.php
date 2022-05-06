<?php

namespace App\Services\Logs;

use App\Models\Vendor\Logs;
use App\Models\Vendor\States;

class VendorLogService
{
    /**
     * @param string $message
     * @param string $vendorService
     * @param null   $httpCode
     * @param array  $data
     */
    public static function writeError(string $message, string $vendorService, $httpCode = null, $data = [])
    {
        Logs::create([
            'message'        => $message,
            'vendor_service' => $vendorService,
            'http_code'      => $httpCode,
            'data'           => $data,
        ])->save();
    }
}
