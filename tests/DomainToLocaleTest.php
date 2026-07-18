<?php

namespace JordJD\LaravelDomainToLocale\Tests;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use JordJD\LaravelDomainToLocale\Http\Middleware\DomainToLocale;
use PHPUnit\Framework\TestCase;

class DomainToLocaleTest extends TestCase
{
    private $app;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app = new Application();
        $this->app->instance('config', new Repository(array(
            'app' => array('locale' => 'en'),
            'domain-to-locale' => array(
                'map' => array(
                    'EXAMPLE.COM.' => 'en-GB',
                    '*.example.fr' => 'fr',
                ),
                'fallback' => 'de',
            ),
        )));
        $this->app->instance('translator', new class {
            public function setLocale($locale)
            {
            }
        });
    }

    protected function tearDown(): void
    {
        Application::setInstance(null);
        parent::tearDown();
    }

    public function testExactHostMatchingIsCaseInsensitiveAndIgnoresTrailingDot()
    {
        $this->handle(Request::create('https://example.com./'));
        $this->assertSame('en-GB', $this->app->getLocale());
    }

    public function testWildcardMatchesSubdomainsButNotTheBareHost()
    {
        $this->handle(Request::create('https://shop.eu.example.fr/'));
        $this->assertSame('fr', $this->app->getLocale());

        $this->handle(Request::create('https://example.fr/'));
        $this->assertSame('de', $this->app->getLocale());
    }

    public function testFallbackIsAppliedToUnmappedHosts()
    {
        $this->handle(Request::create('https://unknown.example/'));
        $this->assertSame('de', $this->app->getLocale());
    }

    private function handle(Request $request)
    {
        return (new DomainToLocale())->handle($request, function () {
            return 'next';
        });
    }
}
