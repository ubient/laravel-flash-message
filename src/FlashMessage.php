<?php

namespace Ubient\FlashMessage;

use LogicException;
use PHPUnit\Framework\Assert;

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
     * @param  string  $level
     * @param  string  $message
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
     * @param  string  $level
     * @param  string|null  $value
     * @param  string  $message
     * @return void
     */
    public static function assert(string $level, string $value = null, string $message = ''): void
    {
        if (! class_exists("\PHPUnit\Framework\Assert")) {
            throw new LogicException('Could not assert: PHPUnit is not installed or is of incompatible version.');
        }

        Assert::assertThat(
            session()->get('flash_message'),
            new HasFlashMessageConstraint($level, $value),
            $message
        );
    }
}
