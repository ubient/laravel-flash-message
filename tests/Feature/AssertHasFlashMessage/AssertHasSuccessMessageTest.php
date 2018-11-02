<?php

namespace Ubient\FlashMessage\Tests\Feature\AssertHasFlashMessage;

use Ubient\FlashMessage\Tests\TestCase;
use PHPUnit\Framework\ExpectationFailedException;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 */
class AssertHasSuccessMessageTest extends TestCase
{
    /** @test */
    public function it_should_assert_the_flash_message_was_set(): void
    {
        app('router')->get('/', function () {
            return redirect('/')->withSuccessMessage('I have an unfortunate personality.');
        });

        tap($this->get('/'), function ($response) {
            $response->assertHasSuccessMessage();
        });
    }

    /** @test */
    public function it_should_assert_the_flash_message_was_set_and_has_the_expected_message(): void
    {
        $message = 'Vision is the true creative rhythm.';
        app('router')->get('/', function () use ($message) {
            return redirect('/')->withSuccessMessage($message);
        });

        tap($this->get('/'), function ($response) use ($message) {
            $response->assertHasSuccessMessage($message);
        });
    }

    /** @test */
    public function it_should_throw_an_exception_for_having_no_flash_message_set(): void
    {
        app('router')->get('/', function () {
            return redirect('/');
        });

        tap($this->get('/'), function ($response) {
            $this->expectException(ExpectationFailedException::class);
            $response->assertHasSuccessMessage();
        });
    }

    /** @test */
    public function it_should_throw_an_exception_for_having_no_flash_message_set_with_the_expected_message(): void
    {
        app('router')->get('/', function () {
            return redirect('/');
        });

        tap($this->get('/'), function ($response) {
            $this->expectException(ExpectationFailedException::class);
            $response->assertHasSuccessMessage('In the future, everyone will be famous for 15 minutes.');
        });
    }

    /** @test */
    public function it_should_throw_an_exception_for_having_a_different_message(): void
    {
        app('router')->get('/', function () {
            return redirect('/')->withSuccessMessage('Nine-tenths of wisdom is being wise in time.');
        });

        tap($this->get('/'), function ($response) {
            $this->expectException(ExpectationFailedException::class);
            $response->assertHasSuccessMessage('A wide screen just makes a bad film twice as bad.');
        });
    }

    /** @test */
    public function it_should_throw_an_exception_for_having_the_expected_message_but_a_different_flash_message_type(): void
    {
        $message = "There's a difference between a philosophy and a bumper sticker.";
        app('router')->get('/', function () use ($message) {
            return redirect('/')->withSuccessMessage($message);
        });

        tap($this->get('/'), function ($response) use ($message) {
            $this->expectException(ExpectationFailedException::class);
            $response->assertHasWarningMessage($message);
        });
    }

    /** @test */
    public function it_should_throw_an_exception_for_having_a_different_flash_message_type(): void
    {
        app('router')->get('/', function () {
            return redirect('/')->withSuccessMessage('The less we deserve good fortune, the more we hope for it.');
        });

        tap($this->get('/'), function ($response) {
            $this->expectException(ExpectationFailedException::class);
            $response->assertHasWarningMessage();
        });
    }
}
