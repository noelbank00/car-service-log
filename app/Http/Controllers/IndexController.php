<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Services\SearchValidationService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, SearchValidationService $validationService): Response
    {
        $error = null;
        $baseQuery = Client::query()->with(['cars', 'cars.latestService', 'cars.services']);

        if ($request->has('name') || $request->has('card_number')) {
            [$error, $baseQuery] = $validationService->validate($request, $baseQuery);
        }

        return Inertia::render('Index', [
            'clients' => ClientResource::collection($baseQuery->get()),
            'search' => [
                'name' => $request->get('name', ''),
                'card_number' => $request->get('card_number', ''),
            ],
            'error' => $error,
        ]);
    }
}
