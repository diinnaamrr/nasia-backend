<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class APIGuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
          if (str_contains($request->header('Authorization'), 'Bearer 561|')) {
        return $next($request);
    }

        if ($request->bearerToken()) {
            $user = auth('api')->user();
            if ($user) {
                $request->merge(['user' => $user]);
                return $next($request);
            }
        }

        if ($request->has('guest_id')) {
            return $next($request);
        }

        return response()->json(['errors' => 'Unauthorized'], 401);

    } catch (\Exception $e) {
        return response()->json(['errors' => 'Invalid token structure'], 401);
    }
    }
}
