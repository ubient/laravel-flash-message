<?php

namespace Ubient\FlashMessage\Unit\PHPUnit;

use PHPUnit\Framework\TestFailure;
use Ubient\FlashMessage\Tests\TestCase;
use PHPUnit\Framework\ExpectationFailedException;
use Ubient\FlashMessage\HasFlashMessageConstraint;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 */
class HasFlashMessageConstraintTest extends TestCase
{
    protected function assertFailingConstraint($expected, $actual, $expectedErrorMessage)
    {
        $constraint = new HasFlashMessageConstraint($expected['level'], $expected['message']);

        try {
            $constraint->evaluate($actual);
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                $expectedErrorMessage."\n",
                TestFailure::exceptionToString($e)
            );

            return;
        }

        throw new \LogicException('The evaluated constrain did not fail as expected.');
    }

    /** @test */
    public function it_should_assert_the_flash_message_was_set(): void
    {
        $expected = ['level' => 'success', 'message' => null];
        $actual = ['level' => $expected['level'], 'message' => 'A flashed message'];
        $constraint = new HasFlashMessageConstraint($expected['level'], $expected['message']);

        $this->assertTrue($constraint->evaluate($actual, '', true));
        $this->assertEquals('has a flash message', $constraint->toString());
    }

    /** @test */
    public function it_should_assert_the_flash_message_was_set_and_has_the_expected_message(): void
    {
        $expected = ['level' => 'success', 'message' => 'A flashed message'];
        $constraint = new HasFlashMessageConstraint($expected['level'], $expected['message']);

        $this->assertTrue($constraint->evaluate($expected, '', true));
        $this->assertEquals('has a flash message', $constraint->toString());
    }

    /** @test */
    public function it_should_throw_an_exception_for_having_no_flash_message_set(): void
    {
        $expected = ['level' => 'success', 'message' => null];
        $actual = [];

        $this->assertFailingConstraint(
            $expected,
            $actual,
            'Failed asserting that a [success] flash message is set.'
        );
    }

    /** @test */
    public function it_should_throw_an_exception_for_having_no_flash_message_set_with_the_expected_message(): void
    {
        $expected = ['level' => 'success', 'message' => 'A flashed message'];
        $actual = [];

        $this->assertFailingConstraint(
            $expected,
            $actual,
            'Failed asserting that a [success] flash message is set with the expected value.'
        );
    }

    /** @test */
    public function it_should_throw_an_exception_for_having_a_different_message(): void
    {
        $expected = ['level' => 'success', 'message' => 'A flashed message'];
        $actual = ['level' => $expected['level'], 'message' => 'Some completely different message'];
        $expectedMessage = <<<'EOF'
Failed asserting that a [success] flash message is set with the expected value.
--- Expected
+++ Actual
@@ @@
-A flashed message
+Some completely different message
EOF;
        $this->assertFailingConstraint(
            $expected,
            $actual,
            $expectedMessage
        );
    }

    /** @test */
    public function it_should_throw_an_exception_for_having_the_expected_message_but_a_different_flash_message_type(): void
    {
        $expected = ['level' => 'success', 'message' => 'A flashed message'];
        $actual = ['level' => 'warning', 'message' => $expected['message']];

        $this->assertFailingConstraint(
            $expected,
            $actual,
            'Failed asserting that a [success] flash message is set with the expected value.'
        );
    }

    /** @test */
    public function it_should_throw_an_exception_for_having_a_different_flash_message_type(): void
    {
        $expected = ['level' => 'error', 'message' => null];
        $actual = ['level' => 'success', 'message' => 'A flashed message'];

        $this->assertFailingConstraint(
            $expected,
            $actual,
            'Failed asserting that a [error] flash message is set.'
        );
    }
}
