<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;

abstract class Controller
{
    /**
     * Authorizes a user for a specific ability on a given model.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException If the user is not authorized.
     */
    public function authorize(string $ability, Model $model): void
    {
        if (! auth()->user()->can(abilities: $ability, arguments: $model)) {
            abort(403);
        }
    }
}
