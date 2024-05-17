<?php

declare(strict_types = 1);

$inputLines = [
    "d - e -> a",
    "a + b -> c",
    "2 -> d",
    "1 -> e",
    "f -> b",
    "4 -> h",
    "g + h -> f",
    "3 -> g",
];

$operations = [];

foreach ($inputLines as $line) {
    preg_match("/(.*)\s+->\s+([a-z]+)\s*/", $line, $matches);
    $operations[$matches[2]] = $matches[1];
}

function getValue(string $variable, array &$operations): int {
    if (preg_match("/^\d+$/", $operations[$variable]) === 1) {
        return (int) $operations[$variable];
    }

    if (preg_match("/^([a-z]+)$/", $operations[$variable], $matches) === 1) {
        return $operations[$variable] = getValue($matches[1], $operations);
    }

    if (preg_match("/^([a-z]+)\s*\+\s*([a-z]+)$/", $operations[$variable], $matches) === 1) {
        return $operations[$variable] = getValue($matches[1], $operations) + getValue($matches[2], $operations);
    }

    if (preg_match("/^([a-z]+)\s*\-\s*([a-z]+)$/", $operations[$variable], $matches) === 1) {
        return $operations[$variable] = getValue($matches[1], $operations) - getValue($matches[2], $operations);
    }

    throw new \Exception("Invalid operation: {$operations[$variable]}");
}

echo "Value of 'c' is " .  getValue('c', $operations);
