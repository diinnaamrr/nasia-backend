<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\CentralLogics\Helpers;

class DmTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check for token in Authorization header first (Bearer token)
        $token = null;
        
        if ($request->bearerToken()) {
            $token = $request->bearerToken();
        } elseif ($request->has('token')) {
            // Fallback to query/body parameter for backward compatibility
            $token = $request->input('token');
        }
        
        if (!$token) {
            return response()->json([
                'errors' => [
                    ['code' => 'unauthorized', 'message' => 'Token is required']
                ]
            ], 401);
        }
        
        // Find delivery man by token
        $deliveryMan = \App\Models\DeliveryMan::withoutGlobalScope(\App\Scopes\ZoneScope::class)->where('auth_token', $token)->first();
        
        if (!$deliveryMan) {
            return response()->json([
                'errors' => [
                    ['code' => 'unauthorized', 'message' => 'Invalid token']
                ]
            ], 401);
        }
        
        // Store the token and authenticated delivery man in the request
        $request->merge([
            'token' => $token,
            'authenticated_delivery_man' => $deliveryMan
        ]);
        
        return $next($request);
    }
}
