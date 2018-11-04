<?php

namespace Ubient\FlashMessage;

use PHPUnit\Framework\Assert as PHPUnit;

class FlashMessage
{
    /**
     * A list of all supported "flash message" levels.
     *
     * @return array
     */
    public static function levels(): array
    {
        return [
            'info',
            'success',
            'warning',
            'error',
        ];
    }

    /**
     * Flashes the given "flash message" to the session.
     *
     * @return void
     */
    public static function set(string $level, string $message): void
    {
        session()->put('flash_message', [
            'message' => $message,
            'level' => $level,
        ]);
    }

    /**
     * Asserts that the "flash message" is set as expected.
     *
     * @return void
     */
    public static function assert(string $level, $value = null, string $message = ''): void
    {
        PHPUnit::assertThat(
            session()->get('flash_message'),
            new HasFlashMessageConstraint($level, $value),
            $message
        );
    }
}
