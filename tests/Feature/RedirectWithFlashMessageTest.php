<?php

namespace Ubient\FlashMessage\Tests\Feature;

use Ubient\FlashMessage\FlashMessage;
use Ubient\FlashMessage\Tests\TestCase;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 */
class RedirectWithFlashMessageTest extends TestCase
{
    /** @test */
    public function set_the_info_flash_message(): void
    {
        $message = 'Vision is the true creative rhythm.';
        app('router')->get('/', function () use ($message) {
            return redirect('/')->withInfoMessage($message);
        });

        tap($this->get('/'), function ($response) use ($message) {
            $response->assertHasInfoMessage($message);
        });
    }

    /** @test */
    public function set_the_success_flash_message(): void
    {
        $message = 'I have an unfortunate personality.';
        app('router')->get('/', function () use ($message) {
            return redirect('/')->withSuccessMessage($message);
        });

        tap($this->get('/'), function ($response) use ($message) {
            $response->assertHasSuccessMessage($message);
        });
    }

    /** @test */
    public function set_the_warning_flash_message(): void
    {
        $message = 'In the future, everyone will be famous for 15 minutes.';
        app('router')->get('/', function () use ($message) {
            return redirect('/')->withWarningMessage($message);
        });

        tap($this->get('/'), function ($response) use ($message) {
            $response->assertHasWarningMessage($message);
        });
    }

    /** @test */
    public function set_the_error_flash_message(): void
    {
        $message = "There's a difference between a philosophy and a bumper sticker.";
        app('router')->get('/', function () use ($message) {
            return redirect('/')->withErrorMessage($message);
        });

        tap($this->get('/'), function ($response) use ($message) {
            $response->assertHasErrorMessage($message);
        });
    }
}
