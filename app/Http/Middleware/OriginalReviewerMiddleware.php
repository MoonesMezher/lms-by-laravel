<?php

namespace App\Http\Middleware;

use App\Models\Review;
use Auth;
use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Contracts\Providers\Auth as ProvidersAuth;
use Symfony\Component\HttpFoundation\Response;

class OriginalReviewerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $review = Review::find($request->route('id'));

        if(!($review->user_id === $request->user()->id)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
