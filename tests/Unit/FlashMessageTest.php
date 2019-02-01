<?php

namespace Ubient\FlashMessage\Tests\Unit;

use Ubient\FlashMessage\FlashMessage;
use Ubient\FlashMessage\Tests\TestCase;

class FlashMessageTest extends TestCase
{
    /** @test */
    public function has_a_levels_method(): void
    {
        $expected = ['info', 'success', 'warning', 'error'];
        $actual = FlashMessage::levels();

        $this->assertEquals($expected, $actual);
    }

    /** @test */
    public function has_an_assert_method(): void
    {
        $flashData = ['level' => 'success', 'message' => 'Example Message'];
        session()->flash('flash_message', $flashData);

        FlashMessage::assert($flashData['level'], $flashData['message']);
    }

    /** @test */
    public function has_a_set_method(): void
    {
        $flashData = ['level' => 'success', 'message' => 'Example Message'];

        FlashMessage::set($flashData['level'], $flashData['message']);

        $this->assertEquals($flashData, session()->get('flash_message'));
        $this->assertEquals($flashData, session()->get('flash_message'));
    }
}
