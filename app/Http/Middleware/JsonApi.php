<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Class JsonApi
 * From https://laracasts.com/discuss/channels/laravel/how-to-validate-json-input-using-requests?page=1 (fureszpeter)
 * @package App\Http\Middleware
 */
class JsonApi
{
    const METHODS = [
        'POST', 'PUT', 'PATCH'
    ];

    /**
     * @param Request $request
     * @param Closure $next
     * @return Closure
     */
    public function handle(Request $request, Closure $next)
    {
        if (in_array($request->getMethod(), self::METHODS)) {
            $request->merge(\json_decode($request->getContent(), true) ?? []);
        }
        return $next($request);
    }
}
