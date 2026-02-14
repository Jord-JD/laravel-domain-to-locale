<?php

namespace JordJD\LaravelDomainToLocale\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DomainToLocale
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $map = config('domain-to-locale.map');
        $host = $request->getHost();

        if (is_array($map) && array_key_exists($host, $map)) {
            $locale = $map[$host];
            app()->setLocale($locale);
        }

        return $next($request);
    }
}