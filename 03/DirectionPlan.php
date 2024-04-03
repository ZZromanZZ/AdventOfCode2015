<?php

declare(strict_types = 1);

class DirectionPlan {

    /**
     * @var array<string>
     */
    private array $directions;

    private int $currentDirectionIndex = 0;

    public function __construct(array $directions)
    {
        $this->directions = $directions;
    }

    public function getNextDirection(): ?string
    {
        $direction = null;

        if (isset($this->directions[$this->currentDirectionIndex])) {
            $direction = $this->directions[$this->currentDirectionIndex];
            $this->currentDirectionIndex++;
        }

        return $direction;
    }

}
