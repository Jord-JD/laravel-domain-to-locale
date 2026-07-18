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
        $host = strtolower(rtrim($request->getHost(), '.'));
        $locale = $this->localeForHost($host, $map);

        if ($locale === null) {
            $locale = config('domain-to-locale.fallback');
        }

        if (is_string($locale) && $locale !== '') {
            app()->setLocale($locale);
        }

        return $next($request);
    }

    /**
     * Resolve an exact or wildcard host mapping.
     *
     * @param string $host
     * @param mixed $map
     * @return string|null
     */
    private function localeForHost($host, $map)
    {
        if (!is_array($map)) {
            return null;
        }

        foreach ($map as $configuredHost => $locale) {
            if (strtolower(rtrim($configuredHost, '.')) === $host) {
                return $locale;
            }
        }

        foreach ($map as $configuredHost => $locale) {
            $configuredHost = strtolower(rtrim($configuredHost, '.'));
            if (strpos($configuredHost, '*.') !== 0) {
                continue;
            }

            $suffix = substr($configuredHost, 1);
            $baseHost = substr($configuredHost, 2);
            if ($host !== $baseHost && substr($host, -strlen($suffix)) === $suffix) {
                return $locale;
            }
        }

        return null;
    }
}
