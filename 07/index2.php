<?php

declare(strict_types = 1);

$wires = [];
$handle = fopen("input.txt", "r");

while (($line = fgets($handle)) !== false) {
    preg_match("/(.+)\s+->\s+([a-z]+)/", $line, $matches);
    $wires[$matches[2]] = $matches[1];
}

fclose($handle);

function getWireSignal(string $wire, array &$wires): int {
    if (!isset($wires[$wire])) {
        throw new \Exception("Wire {$wire} not found");
    }

    if (is_int($wires[$wire]) || preg_match("/^\d+$/", $wires[$wire]) === 1) {
        return (int) $wires[$wire];
    }

    if (preg_match("/^([a-z]+)$/", $wires[$wire], $matches) === 1) {
        return $wires[$wire] = getWireSignal($matches[1], $wires);
    }

    if (preg_match("/^NOT ([a-z]+)$/", $wires[$wire], $matches) === 1) {
        return $wires[$wire] = ~getWireSignal($matches[1], $wires);
    }

    if (preg_match("/^([a-z]+) AND ([a-z]+)$/", $wires[$wire], $matches) === 1) {
        return $wires[$wire] = getWireSignal($matches[1], $wires) & getWireSignal($matches[2], $wires);
    }

    if (preg_match("/^(\d+) AND ([a-z]+)$/", $wires[$wire], $matches) === 1) {
        return $wires[$wire] = (int) $matches[1] & getWireSignal($matches[2], $wires);
    }

    if (preg_match("/^([a-z]+) AND (\d+)$/", $wires[$wire], $matches) === 1) {
        return $wires[$wire] = getWireSignal($matches[1], $wires) & (int) $matches[2];
    }

    if (preg_match("/^([a-z]+) OR ([a-z]+)$/", $wires[$wire], $matches) === 1) {
        return $wires[$wire] = getWireSignal($matches[1], $wires) | getWireSignal($matches[2], $wires);
    }

    if (preg_match("/^([a-z]+) LSHIFT (\d+)$/", $wires[$wire], $matches) === 1) {
        return $wires[$wire] = getWireSignal($matches[1], $wires) << (int) $matches[2];
    }

    if (preg_match("/^([a-z]+) RSHIFT (\d+)$/", $wires[$wire], $matches) === 1) {
        return $wires[$wire] = getWireSignal($matches[1], $wires) >> (int) $matches[2];
    }

    throw new \Exception("Invalid operation: {$wires[$wire]}");
}

$aSignal = getWireSignal('a', $wires);

echo $aSignal . "\n";

$wires = [];
$handle = fopen("input.txt", "r");

while (($line = fgets($handle)) !== false) {
    preg_match("/(.+)\s+->\s+([a-z]+)/", $line, $matches);

    if ($matches[2] === 'b') {
        $matches[1] = $aSignal;
    }

    $wires[$matches[2]] = $matches[1];
}

fclose($handle);

echo getWireSignal('a', $wires) . "\n";
