<?php

namespace Ubient\FlashMessage\Tests;

use LogicException;
use Orchestra\Testbench\TestCase as Orchestra;
use Ubient\FlashMessage\FlashMessageServiceProvider;

class TestCase extends Orchestra
{
    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            FlashMessageServiceProvider::class,
        ];
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
