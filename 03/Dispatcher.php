<?php

declare(strict_types = 1);

class Dispatcher
{
    private DirectionPlan $directionPlan;

    private array $courierLocations = [];

    private CourierLocationDecisionStrategy $locationDecisionStrategy;

    private array $visitedLocations = [];

    public function __construct(DirectionPlan $directionPlan, CourierLocationDecisionStrategy $locationDecisionStrategy, int $numberOfCouriers = 1)
    {
        $this->directionPlan = $directionPlan;
        $this->locationDecisionStrategy = $locationDecisionStrategy;

        for ($i = 0; $i < $numberOfCouriers; $i++) {
            $this->courierLocations[] = new CourierLocation();
        }
    }

    public function dispatch(): void
    {
        // all locations are marked as visited at the beginning
        foreach ($this->courierLocations as $courierLocation) {
            $this->markCourierLocationAsVisited($courierLocation);
        }

        $stepCount = 0;

        while (($direction = $this->directionPlan->getNextDirection()) !== null) {
            $courierLocation = $this->locationDecisionStrategy->decide($stepCount, $this->courierLocations);
            $courierLocation->move($direction);
            $this->markCourierLocationAsVisited($courierLocation);
            $stepCount++;
        }
    }

    public function getCountOfVisitedLocations(): int
    {
        return count($this->visitedLocations);
    }

    protected function markCourierLocationAsVisited(CourierLocation $location): void
    {
        //$this->visitedLocations["{$location->getX()}_{$location->getY()}"] = true;
        $this->visitedLocations["{$location}"] = true;
    }

}
