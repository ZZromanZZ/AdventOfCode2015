<?php

declare(strict_types = 1);

interface CourierLocationDecisionStrategy {

    public function decide(int $stepCount, array $locations): CourierLocation;

}
