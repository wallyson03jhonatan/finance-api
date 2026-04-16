<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureEmailIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->email_verification_status !== 'confirmed') {
            return response()->json([
                'message' => 'E-mail não verificado.',
            ], 403);
        }

        return $next($request);
    }
}