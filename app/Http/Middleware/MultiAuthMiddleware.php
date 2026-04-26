<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class MultiAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-KEY');

        // Check API Key
        if ($apiKey && $apiKey === env('APP_KEY')) {
            return $next($request);
        }

        // Check Bearer token manually
        $bearerToken = $request->bearerToken();

        if ($bearerToken) {
            $accessToken = PersonalAccessToken::findToken($bearerToken);

            if ($accessToken && $accessToken->tokenable) {
                // Log the user into the request so $request->user() works later
                $request->setUserResolver(fn() => $accessToken->tokenable);
                return $next($request);
            }
        }

        return response()->json(['Error' => 'Usuari no autoritzat'], 401);
    }
}