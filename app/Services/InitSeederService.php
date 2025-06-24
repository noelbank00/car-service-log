<?php

namespace App\Services;

use App\Models\Car;
use App\Models\Client;
use App\Models\Service;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use stdClass;

class InitSeederService
{
    public function clients(): void
    {
        $json = Storage::disk('data')->get('clients.json');
        if (empty($json)) {
            Log::error('Data file clients.json is empty or not found.');
            return;
        }

        /** @var stdClass $clients */
        $clients = json_decode($json);
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('JSON decode error: ' . json_last_error_msg());
            return;
        }

        foreach ($clients as $client) {
            Client::query()->forceCreate([
                'id' => $client->id,
                'name' => $client->name,
                'card_number' => $client->idcard,
            ]);
        }

    }

    public function cars(): void
    {
        $json = Storage::disk('data')->get('cars.json');
        if (empty($json)) {
            Log::error('Data file cars.json is empty or not found.');
            return;
        }

        /** @var stdClass $cars */
        $cars = json_decode($json);
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('JSON decode error: ' . json_last_error_msg());
            return;
        }

        foreach ($cars as $car) {
            Car::query()->forceCreate([
                'id' => $car->id,
                'client_id' => $car->client_id,
                'type' => $car->type,
                'registered' => $car->registered,
                'ownbrand' => $car->ownbrand,
                'accidents' => $car->accident,
            ]);
        }

    }

    public function service(): void
    {
        $json = Storage::disk('data')->get('services.json');
        if (empty($json)) {
            Log::error('Data file service.json is empty or not found.');
            return;
        }

        /** @var stdClass $services */
        $services = json_decode($json);
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('JSON decode error: ' . json_last_error_msg());
            return;
        }

        foreach ($services as $service) {
            Service::query()->forceCreate([
                'id' => $service->id,
                'client_id' => $service->client_id,
                'car_id' => $service->car_id,
                'log_number' => $service->lognumber,
                'event' => $service->event,
                'event_time' => $service->eventtime,
                'document_id' => $service->document_id,
            ]);
        }
    }
}