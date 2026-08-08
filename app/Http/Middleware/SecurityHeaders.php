<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (property_exists($response, 'headers')) {
            $response->headers->set('X-Frame-Options', 'DENY');
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

            if (app()->environment('production')) {
                $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
                
                $csp = "default-src 'self'; " .
                       "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.gstatic.com; " .
                       "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; " .
                       "font-src 'self' https://fonts.gstatic.com; " .
                       "img-src 'self' data: https:; " .
                       "connect-src 'self' https:; " .
                       "frame-src 'self'; " .
                       "object-src 'none'; " .
                       "base-uri 'self'; " .
                       "form-action 'self';";
                       
                $response->headers->set('Content-Security-Policy', $csp);
            }
        }

        return $response;
    }
}
