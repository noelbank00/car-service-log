<?php

namespace App\Http\Middleware;

use App\Models\Car;
use App\Models\Client;
use App\Models\Service;
use App\Services\InitSeederService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DatabaseInitializerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var InitSeederService $initSeeder */
        $initSeeder = app(InitSeederService::class);

        if (Client::query()->count() === 0) {
            $initSeeder->clients();
        }

        if (Car::query()->count() === 0) {
            $initSeeder->cars();
        }

        if (Service::query()->count() === 0) {
            $initSeeder->service();
        }

        return $next($request);
    }
}
