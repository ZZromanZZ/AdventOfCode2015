<?php

declare(strict_types = 1);

$handle = fopen("input.txt", "r");

$lights = [];

while (($line = fgets($handle)) !== false) {
    preg_match("/(turn on|turn off|toggle) (\d+),(\d+) through (\d+),(\d+)/", $line, $matches);

    $fromX = (int) $matches[2];
    $fromY = (int) $matches[3];
    $toX = (int) $matches[4];
    $toY = (int) $matches[5];

    for ($x = $fromX; $x <= $toX; $x++) {
        for ($y = $fromY; $y <= $toY; $y++) {
            $lights[$x][$y] = process($lights[$x][$y] ?? false, $matches[1]);
        }
    }
}

fclose($handle);

function process (bool $value, string $command): bool {
    return match ($command) {
        "turn on" => true,
        "turn off" => false,
        "toggle" => !$value,
    };
}

$numberOfLightsOn = 0;

for ($x = 0; $x < 1000; $x++) {
    for ($y = 0; $y < 1000; $y++) {
        if (($lights[$x][$y] ?? false) === true) {
            $numberOfLightsOn++;
        }
    }
}

echo "Number of lights on is {$numberOfLightsOn}" . PHP_EOL;
