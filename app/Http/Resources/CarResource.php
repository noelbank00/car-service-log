<?php

namespace App\Http\Resources;

use App\Models\Car;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Car
 */
class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Service|null $latestService */
        $latestService = $this->latestService;

        ServiceResource::carData($this);

        return [
            'id' => $this->id,
            'type' => $this->type,
            'registered' => $this->registered->format('Y-m-d H:i:s'),
            'ownbrand' => $this->ownbrand,
            'accidents' => $this->accidents,
            'last_service_name' => $latestService?->event,
            'last_service_date' => $latestService?->event_time?->format('Y-m-d H:i:s'),
            'services' => ServiceResource::collection($this->services),
        ];
    }
}
