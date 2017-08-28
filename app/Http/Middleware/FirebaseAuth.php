<?php

namespace App\Http\Middleware;

use App\Model\User;
use Closure;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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
        try {
            $authToken = $request->headers->get('Authorization');
            if ($authToken === null) {
                throw new \InvalidArgumentException('No authentication token found');
            }
            Log::info('authToken => ' .  $authToken);
            $serviceAccount = ServiceAccount::fromJsonFile(config_path() . '/firebase.json');
            $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();
            $tokenHandler = $firebase->getTokenHandler();
            $token = $tokenHandler->verifyIdToken($authToken);
            $userId = $token->getClaim('user_id');
            Log::info('userId => ' . $userId);
            $user = User::where('firebase_uid', $userId)->firstOrFail();
            if (empty($user)) {
                throw new \InvalidArgumentException('No user found');
            }
            Auth::login($user);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return response()->json($errorMessage, $errorCode);
        }
        return $next($request);

    }
}
