<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SearchValidationService
{
    public function validate(Request $request, Builder $builder): array
    {
        if ($request->has('name') && $request->has('card_number')) {
            return ['Mind két mező kitöltése nem lehetséges.', $builder];
        }

        if ($request->has('name')) {
            return $this->name($request->get('name'), $builder);
        }

        if ($request->has('card_number')) {
            return $this->cardNumber($request->get('card_number'), $builder);
        }

        return [null, $builder];
    }

    public function name(string $name, Builder $builder)
    {
        if (empty($name)) {
            return ['A keresett név nem lehet üres.', $builder];
        }

        $builder->where('name', 'like', '%' . $name . '%');
        return [null, $builder];
    }

    public function cardNumber(string $number, Builder $builder): array
    {
        if (empty($number) || $number <= 0) {
            return ['A keresett kártyaszám nem lehet nulla vagy negatív.', $builder];
        }

        if (!preg_match('/^\d+$/', $number)) {
            return ['A kártyaszám csak számjegyeket tartalmazhat.', $builder];
        }

        $builder->where('card_number', $number);

        return [null, $builder];
    }
}