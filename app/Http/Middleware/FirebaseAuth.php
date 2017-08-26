<?php

namespace App\Http\Middleware;

use Closure;

class FirebaseAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $errorMessage = 'Not authorized';
        $errorCode = 401;
        $authToken = $request->headers->get('Authorization');
        if ($authToken === null) {
            return response()->json($errorMessage, $errorCode);
        }
        return $next($request);
    }
}
