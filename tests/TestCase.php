<?php

namespace Ubient\FlashMessage\Tests;

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
}
