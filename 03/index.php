<?php

declare(strict_types=1);

require_once 'CourierLocation.php';
require_once 'CourierLocationDecisionStrategy.php';
require_once 'OneByOneCourierLocationDecisionStrategy.php';
require_once 'OneUpToCourierNumberCourierLocationDecisionStrategy.php';
require_once 'Dispatcher.php';
require_once 'DirectionPlan.php';

$numberOfCouriers = 2;

$dispatcher = new Dispatcher(
    directionPlan: new DirectionPlan(str_split(trim(file_get_contents('input.txt')))),
    locationDecisionStrategy: new OneByOneCourierLocationDecisionStrategy(),
    numberOfCouriers: $numberOfCouriers,
);

$dispatcher->dispatch();

echo "Number of visited houses for {$numberOfCouriers} courier(s) is {$dispatcher->getCountOfVisitedLocations()}" . PHP_EOL;
echo PHP_EOL;
echo "Hint: number of visited houses for one courier should be 2572, for two couriers it should be 2631" . PHP_EOL;
