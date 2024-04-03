<?php

declare(strict_types = 1);

class OneByOneCourierLocationDecisionStrategy implements CourierLocationDecisionStrategy
{

    public function decide(int $stepCount, array $locations): CourierLocation
    {
        if (count($locations) === 0) {
            throw new InvalidArgumentException('No locations provided');
        }

        return $locations[$stepCount % count($locations)];
    }

}
