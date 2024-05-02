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
            $lights[$x][$y] = process($lights[$x][$y] ?? 0, $matches[1]);
        }
    }
}

fclose($handle);

function process (int $value, string $command): int {
    return match ($command) {
        "turn on" => ++$value,
        "turn off" => --$value < 0 ? 0 : $value,
        "toggle" => $value + 2,
    };
}

$totalBrightness = 0;

for ($x = 0; $x < 1000; $x++) {
    for ($y = 0; $y < 1000; $y++) {
        $totalBrightness += $lights[$x][$y] ?? 0;
    }
}

echo "Total brightness is {$totalBrightness}" . PHP_EOL;
