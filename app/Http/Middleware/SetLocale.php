<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $availableLocales = config('app.available_locales');
        $locale = $request->route('locale');

        if (! in_array($locale, $availableLocales )) {
            $locale = config('app.fallback_locale');
        }

        app()->setLocale($locale);

        URL::defaults(['locale' => $locale]);

        return $next($request);
    }
}
