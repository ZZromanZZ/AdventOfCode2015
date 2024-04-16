<?php

declare(strict_types = 1);

class String2
{

    public function __construct(protected readonly string $value)
    {

    }

    private function containsPairOfAnyTwoLetters(): bool
    {
        return preg_match('/(..).*\1/', $this->value) > 0;
    }

    private function containsOneLetterWhichRepeatsExactlyOnceBetweenThem(): bool
    {
        return preg_match('/(.).\1/', $this->value) > 0;
    }

    public function isNice(): bool
    {
        return $this->containsPairOfAnyTwoLetters() && $this->containsOneLetterWhichRepeatsExactlyOnceBetweenThem();
    }

}
