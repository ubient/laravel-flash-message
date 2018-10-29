<?php

namespace Ubient\FlashMessage;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\ServiceProvider;

class FlashMessageServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerMacros();

        $this->loadViewsFrom(__DIR__ . '/views', 'flash-message');

        $this->publishes([
            __DIR__ . '/views' => base_path('resources/views/vendor/flash-message'),
        ]);
    }

    private function registerMacros(): void
    {
        collect(['info', 'success', 'warning', 'error'])->each(function ($level) {
            $this->registerMacro($level);
        });
    }

    private function registerMacro(string $level): void
    {
        $name = 'with' . ucfirst(strtolower($level)) . 'Message';

        RedirectResponse::macro($name, function ($message) use ($level) {
            return $this->with('flash_message', [
                'message' => $message,
                'level' => $level,
            ]);
        });
    }
}
