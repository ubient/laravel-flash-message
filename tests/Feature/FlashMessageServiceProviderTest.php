<?php

namespace Ubient\FlashMessage\Tests\Feature;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\ServiceProvider;
use Ubient\FlashMessage\Tests\TestCase;
use Illuminate\Foundation\Testing\TestResponse;
use Ubient\FlashMessage\FlashMessageServiceProvider;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 */
class FlashMessageServiceProviderTest extends TestCase
{
    /** @var string */
    protected $pathToViews;

    public function setUp()
    {
        parent::setUp();

        $this->pathToViews = realpath(__DIR__.'/../../src/views');
    }

    /** @test */
    public function it_should_register_all_macros(): void
    {
        $this->assertTrue(RedirectResponse::hasMacro('withInfoMessage'));
        $this->assertTrue(TestResponse::HasMacro('assertHasInfoMessage'));

        $this->assertTrue(RedirectResponse::hasMacro('withSuccessMessage'));
        $this->assertTrue(TestResponse::HasMacro('assertHasSuccessMessage'));

        $this->assertTrue(RedirectResponse::hasMacro('withWarningMessage'));
        $this->assertTrue(TestResponse::HasMacro('assertHasWarningMessage'));

        $this->assertTrue(RedirectResponse::hasMacro('withErrorMessage'));
        $this->assertTrue(TestResponse::HasMacro('assertHasErrorMessage'));
    }

    /** @test */
    public function it_should_load_views(): void
    {
        $hints = view()->getFinder()->getHints();

        $this->assertArrayHasKey('flash-message', $hints);
        $this->assertContains($this->pathToViews, $hints['flash-message']);
    }

    /** @test */
    public function it_publishes_the_views_folder(): void
    {
        $publishPath = base_path('resources/views/vendor/flash-message');

        $this->assertArrayHasKey(FlashMessageServiceProvider::class, ServiceProvider::$publishes);
        $publishes = ServiceProvider::$publishes[FlashMessageServiceProvider::class];

        $this->assertArrayHasKey($this->pathToViews, $publishes);
        $this->assertEquals($publishPath, $publishes[$this->pathToViews]);
    }
}
