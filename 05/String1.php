<?php

declare(strict_types = 1);

class String1
{

    public function __construct(protected readonly string $value)
    {

    }

    private function containsVowels(): bool
    {
        return preg_match('/[aeiou].*[aeiou].*[aeiou]/', $this->value) > 0;
    }

    private function containsConsecutiveCharacter(): bool
    {
        return preg_match('/(.)\1/', $this->value) > 0;
    }

    private function doesNotContainSpecificSequence(): bool {
        return preg_match('/ab|cd|pq|xy/', $this->value) === 0;
    }

    public function isNice(): bool
    {
        return $this->containsVowels() && $this->containsConsecutiveCharacter() && $this->doesNotContainSpecificSequence();
    }

}
