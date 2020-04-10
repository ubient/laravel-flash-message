<?php

namespace Ubient\FlashMessage;

use Illuminate\Support\Arr;
use PHPUnit\Framework\Constraint\Constraint;
use SebastianBergmann\Diff\Differ;

class HasFlashMessageConstraint extends Constraint
{
    /**
     * @var string
     */
    private $expectedLevel;

    /**
     * @var string|null
     */
    private $expectedMessage;

    public function __construct(string $expectedLevel, string $expectedMessage = null)
    {
        $this->expectedLevel = $expectedLevel;
        $this->expectedMessage = $expectedMessage;
    }

    /**
     * Returns a string representation of the constraint.
     */
    public function toString(): string
    {
        return 'has a flash message';
    }

    /**
     * Evaluates the constraint for parameter $other. Returns true if the
     * constraint is met, false otherwise.
     *
     * @param  mixed  $other  value or object to evaluate
     * @return bool
     */
    protected function matches($other): bool
    {
        return $this->hasValidFlashData($other)
            && $this->hasExpectedLevel($other)
            && $this->hasExpectedMessage($other);
    }

    /**
     * Returns the description of the failure.
     *
     * The beginning of failure messages is "Failed asserting that" in most
     * cases. This method should return the second part of that sentence.
     *
     * @param  mixed  $other  evaluated value or object
     * @return string
     */
    protected function failureDescription($other): string
    {
        $message = sprintf('a [%s] flash message is set', $this->expectedLevel);

        if ($this->expectedMessage) {
            return $message.' with the expected value';
        }

        return $message;
    }

    protected function additionalFailureDescription($other): string
    {
        if (! $this->hasValidFlashData($other) || ! $this->hasExpectedLevel($other)) {
            return '';
        }

        $differ = new Differ("--- Expected\n+++ Actual\n");

        return $differ->diff($this->expectedMessage, $other['message']);
    }

    /**
     * Checks whether valid "flash message" data was passed.
     *
     * @param $other
     * @return bool
     */
    private function hasValidFlashData($other): bool
    {
        return is_array($other) && Arr::has($other, ['level', 'message']);
    }

    /**
     * Checks whether the "flash message" level is what we expected.
     *
     * @param $other
     * @return bool
     */
    private function hasExpectedLevel($other): bool
    {
        return $other['level'] === $this->expectedLevel;
    }

    /**
     * Checks whether we expect a message, and if so, whether
     * the "flash message" message is what we expected.
     *
     * @param $other
     * @return bool
     */
    private function hasExpectedMessage($other): bool
    {
        if ($this->expectedMessage === null) {
            return true;
        }

        return $other['message'] === $this->expectedMessage;
    }
}
