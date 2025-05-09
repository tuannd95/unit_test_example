<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param $request
     *
     * @SuppressWarnings("unused")
     *
     * @return string|null
     * @throws AuthenticationException
     */
    protected function redirectTo($request)
    {
        throw new AuthenticationException();
    }
}
