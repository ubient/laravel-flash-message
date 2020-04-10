<?php

namespace Ubient\FlashMessage;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use LogicException;

class FlashMessageServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerMacros();

        $this->loadViewsFrom(__DIR__.'/views', 'flash-message');

        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/vendor/flash-message'),
        ]);
    }

    /**
     * Register all "flash message" macros per alert level.
     *
     * @return void
     */
    private function registerMacros(): void
    {
        collect(FlashMessage::levels())->each(function ($level) {
            $this->registerFlashMessage($level);

            if (App::runningUnitTests() && $this->hasTestResponseClass()) {
                $this->registerHasFlashMessageAssertion($level);
            }
        });
    }

    /**
     * Register the "flash message" macro for the given
     * "alert level" on the redirect response.
     *
     * @param  string  $level
     * @return void
     */
    protected function registerFlashMessage(string $level): void
    {
        $name = 'with'.ucfirst(strtolower($level)).'Message';

        RedirectResponse::macro($name, function ($message) use ($level) {
            FlashMessage::set($level, $message);

            return $this;
        });
    }

    /**
     * Register the "flash message" assertion macro for
     * the given "alert level" on the Test Response.
     *
     * @param  string  $level
     * @return void
     */
    protected function registerHasFlashMessageAssertion(string $level): void
    {
        $name = 'assertHas'.ucfirst(strtolower($level)).'Message';

        /** @var \Illuminate\Foundation\Testing\TestResponse|\Illuminate\Testing\TestResponse $testResponse */
        $testResponse = $this->getTestResponse();
        $testResponse::macro($name, function (string $value = null, string $message = '') use ($level) {
            FlashMessage::assert($level, $value, $message);

            return $this;
        });
    }

    /**
     * Detect and return the correct TestResponse class.
     *
     * @return string
     */
    protected function getTestResponse(): string
    {
        // Laravel >= 7.0
        if (class_exists("\Illuminate\Testing\TestResponse")) {
            return "\Illuminate\Testing\TestResponse";
        }

        // Laravel <= 6.0
        if (class_exists("\Illuminate\Foundation\Testing\TestResponse")) {
            return "\Illuminate\Foundation\Testing\TestResponse";
        }

        throw new LogicException('Could not find TestResponse class.');
    }

    /**
     * Whether or not the TestResponse class exists.
     *
     * @return bool
     */
    protected function hasTestResponseClass(): bool
    {
        try {
            $this->getTestResponse();
        } catch (LogicException $exception) {
            return false;
        }

        return true;
    }
}
