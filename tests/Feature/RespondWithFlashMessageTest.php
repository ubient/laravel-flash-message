<?php

namespace Ubient\FlashMessage\Tests\Feature;

use Ubient\FlashMessage\Tests\TestCase;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 */
class RespondWithFlashMessageTest extends TestCase
{
    /** @test */
    public function it_flashes_data_for_the_info_notification(): void
    {
        $message = 'Vision is the true creative rhythm.';

        $redirect = redirect('fake-route')
            ->withInfoMessage($message);

        $this->assertEquals('flash_message', session()->get('_flash.new.0'));
        $this->assertEquals($message, session('flash_message.message'));
        $this->assertEquals('info', session('flash_message.level'));
    }

    /** @test */
    public function it_flashes_data_for_the_success_notification(): void
    {
        $message = 'I have an unfortunate personality.';

        $redirect = redirect('fake-route')
            ->withSuccessMessage($message);

        $this->assertEquals('flash_message', session()->get('_flash.new.0'));
        $this->assertEquals($message, session('flash_message.message'));
        $this->assertEquals('success', session('flash_message.level'));
    }

    /** @test */
    public function it_flashes_data_for_the_warning_notification(): void
    {
        $message = "There's a difference between a philosophy and a bumper sticker.";

        $redirect = redirect('fake-route')
            ->withWarningMessage($message);

        $this->assertEquals('flash_message', session()->get('_flash.new.0'));
        $this->assertEquals($message, session('flash_message.message'));
        $this->assertEquals('warning', session('flash_message.level'));
    }

    /** @test */
    public function it_flashes_data_for_the_error_notification(): void
    {
        $message = 'The less we deserve good fortune, the more we hope for it.';

        $redirect = redirect('fake-route')
            ->withErrorMessage($message);

        $this->assertEquals('flash_message', session()->get('_flash.new.0'));
        $this->assertEquals($message, session('flash_message.message'));
        $this->assertEquals('error', session('flash_message.level'));
    }
}
