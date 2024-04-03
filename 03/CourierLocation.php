<?php

declare(strict_types = 1);

class CourierLocation {

    private int $x;

    private int $y;

    public function __construct()
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function move(string $character): void
    {
        switch ($character) {
            case '^':
                $this->y++;
                break;
            case 'v':
                $this->y--;
                break;
            case '>':
                $this->x++;
                break;
            case '<':
                $this->x--;
                break;
            default:
                throw new InvalidArgumentException("Invalid character: $character");
        }
    }


    public function __toString(): string
    {
        return "({$this->getX()}_{$this->getY()})";
    }

}
