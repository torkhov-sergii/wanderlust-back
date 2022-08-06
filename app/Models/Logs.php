<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


/**
 * App\Models\VendorLog
 *
 * @property int $id
 * @property string $vendor_service
 * @property int|null $http_code
 * @property string|null $data
 * @property string $message
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $time
 * @method static \Illuminate\Database\Eloquent\Builder|Logs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Logs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Logs query()
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereHttpCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Logs whereVendorService($value)
 * @mixin Eloquent
 */
class Logs extends Model
{
    use HasFactory;

    protected $table = 'vendor_logs';

    protected $casts = [
        'data' => 'array'
    ];

    public $fillable=[
        'message',
        'vendor_service',
        'http_code',
        'data'
    ];

    public $appends = ['time'];

    public function getTimeAttribute(): string
    {
        return $this->created_at->format('H:i:s d-m-Y');
    }

}
