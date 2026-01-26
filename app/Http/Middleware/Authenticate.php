<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;


class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {

        if (!$request->expectsJson()) {
            if ($request->is('vendors/*')) {
                 return route('login');
            } elseif ($request->is('/*')) {
                return route('login');
            } else {
                 return route('login');
            }
        } else {
          return route('login');
        }
    }
}
