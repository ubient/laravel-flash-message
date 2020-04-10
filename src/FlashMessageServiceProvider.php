<?php

namespace Ubient\FlashMessage;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\ServiceProvider;
use Illuminate\Testing\TestResponse;

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
            $this->registerHasFlashMessageAssertion($level);
        });
    }

    /**
     * Register the "flash message" macro for the given
     * "alert level" on the redirect response.
     *
     * @return void
     */
    private function registerFlashMessage(string $level): void
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
     * @return void
     */
    private function registerHasFlashMessageAssertion(string $level): void
    {
        $name = 'assertHas'.ucfirst(strtolower($level)).'Message';

        TestResponse::macro($name, function ($value = null, $message = '') use ($level) {
            FlashMessage::assert($level, $value, $message);

            return $this;
        });
    }
}
