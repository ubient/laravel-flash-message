<?php

namespace Ubient\FlashMessage\Tests\Feature;

use Ubient\FlashMessage\Tests\TestCase;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 */
class ViewFlashMessageTest extends TestCase
{
    const CSS_CLASS_INFO = 'bg-blue-light';
    const CSS_CLASS_SUCCESS = 'bg-green-light';
    const CSS_CLASS_WARNING = 'bg-orange';
    const CSS_CLASS_ERROR = 'bg-red-light';

    public function setUp()
    {
        parent::setUp();

        app('router')->get('display', function () {
            return view('flash-message::alert');
        });
    }

    /** @test */
    public function it_should_display_our_info_message(): void
    {
        $message = 'A wide screen just makes a bad film twice as bad.';

        redirect('display')->withInfoMessage($message);
        $response = $this->get('display');

        $response->assertSeeText($message);
        $response->assertSee(static::CSS_CLASS_INFO);
        $response->assertDontSee(static::CSS_CLASS_ERROR);
    }

    /** @test */
    public function it_should_display_our_success_message(): void
    {
        $message = 'Where there is no vision, there is no hope.';

        redirect('display')->withSuccessMessage($message);
        $response = $this->get('display');

        $response->assertSeeText($message);
        $response->assertSee(static::CSS_CLASS_SUCCESS);
        $response->assertDontSee(static::CSS_CLASS_INFO);
    }

    /** @test */
    public function it_should_display_our_warning_message(): void
    {
        $message = 'Nine-tenths of wisdom is being wise in time.';

        redirect('display')->withWarningMessage($message);
        $response = $this->get('display');

        $response->assertSeeText($message);
        $response->assertSee(static::CSS_CLASS_WARNING);
        $response->assertDontSee(static::CSS_CLASS_SUCCESS);
    }

    /** @test */
    public function it_should_display_our_error_message(): void
    {
        $message = 'Life is the art of drawing without an eraser.';

        redirect('display')->withErrorMessage($message);
        $response = $this->get('display');

        $response->assertSeeText($message);
        $response->assertSee(static::CSS_CLASS_ERROR);
        $response->assertDontSee(static::CSS_CLASS_WARNING);
    }

    /** @test */
    public function it_should_be_backwards_compatible_with_laravels_built_in_status_message(): void
    {
        $message = 'These are used by default in ResetsPasswords.php and SendsPasswordResetEmails.php';

        redirect('display')->with('status', $message);
        $response = $this->get('display');

        $response->assertSeeText($message);
        $response->assertSee(static::CSS_CLASS_SUCCESS);
    }

    /** @test */
    public function it_should_prefer_our_flashed_message_over_laravels_built_in_status_message(): void
    {
        $message = "All I ask is the chance to prove that money can't make me happy.";
        $builtInMessage = 'These are used by default in ResetsPasswords.php and SendsPasswordResetEmails.php';

        redirect('display')
            ->withWarningMessage($message)
            ->with('status', $builtInMessage);

        $response = $this->get('display');

        $response->assertSeeText(e($message));
        $response->assertSee(static::CSS_CLASS_WARNING);
        $response->assertDontSee(e($builtInMessage));
        $response->assertDontSee(static::CSS_CLASS_SUCCESS);
    }

    /** @test */
    public function it_should_display_nothing_when_no_message_was_flashed(): void
    {
        $response = $this->get('display');

        $response->assertViewIs('flash-message::alert');
        $this->assertEmpty($response->content());
    }
}
