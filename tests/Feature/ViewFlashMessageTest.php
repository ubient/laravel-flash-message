<?php

namespace Ubient\FlashMessage\Tests\Feature;

use Ubient\FlashMessage\Tests\TestCase;
use PHPUnit\Framework\ExpectationFailedException;

class ViewFlashMessageTest extends TestCase
{
    const CSS_CLASS_INFO = 'bg-blue-400';

    const CSS_CLASS_SUCCESS = 'bg-green-400';

    const CSS_CLASS_WARNING = 'bg-orange-500';

    const CSS_CLASS_ERROR = 'bg-red-400';

    public function setUp(): void
    {
        parent::setUp();

        app('router')->group(['middleware' => 'web'], function ($router) {
            $router->get('display', function () {
                return view('flash-message::alert');
            });
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

        $response->assertSeeText(e($message), false);
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

    /** @test */
    public function it_should_persist_across_multiple_redirects(): void
    {
        $message = 'Those who do not remember the past are condemned to repeat it.';
        app('router')->group(['middleware' => 'web'], function ($router) use ($message) {
            $router->get('redirect-to-display', function () {
                return redirect('display');
            });
            $router->get('initial', function () use ($message) {
                return redirect('redirect-to-display')->withInfoMessage($message);
            });
        });

        $this->get('initial');
        $response = $this->get('redirect-to-display');

        $response->assertHasInfoMessage($message);
    }

    /** @test */
    public function it_should_only_be_displayed_once(): void
    {
        $message = 'If you want to kill any idea in the world, get a committee working on it.';

        redirect('display')->withInfoMessage($message);
        $this->get('display');
        $response = $this->get('display');

        $this->expectException(ExpectationFailedException::class);
        $response->assertHasInfoMessage($message);
    }
}
