<?php

namespace App\Http\Resources;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Service
 */
class ServiceResource extends JsonResource
{
    public static $car = null;

    public static function carData($carData)
    {
        if (self::$car === null) {
            self::$car = $carData;
        }
    }

    public function toArray(Request $request): array
    {
        return [
            'log_number' => $this->log_number,
            'event' => $this->event,
            'event_time' => ($this->event_time ?? self::$car->registered)?->format('Y-m-d H:i:s'),
            'document_id' => $this->document_id,
        ];
    }
}
