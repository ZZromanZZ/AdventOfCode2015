<?php

declare(strict_types = 1);

function handleShortIntOverflow(int $value): int {
    return $value & 0xFFFF;
}

$wires = [];
$instructions = [];
$handle = fopen("input.txt", "r");

while (($line = fgets($handle)) !== false) {
    $instructions[] = $line;
}

fclose($handle);

$unprocessedOperations = [];

do {
    foreach ($instructions as $key => $instruction) {
        if (preg_match("/(.+)\s+->\s+([a-z]+)/", $instruction, $matches) !== 1) {
            throw new \Exception("Invalid instruction: {$instruction}");
        }

        $instruction = $matches[1];
        $target = $matches[2];
        $matches = [];

        if (preg_match("/^(\d+)$/", $instruction, $matches) === 1) { // assignment
            $wires[$target] = (int) $matches[1];
        } elseif (preg_match("/^([a-z]+)$/", $instruction, $matches) === 1) { // assignment from wire
            if (!isset($wires[$matches[1]])) {
                $unprocessedOperations[$key] = $instruction;

                continue;
            }

            $wires[$target] = $wires[$matches[1]];
        } elseif (preg_match("/^([a-z]+)\s+AND\s+(\d+)$/", $instruction, $matches) === 1) { // AND with wire and number
            if (!isset($wires[$matches[1]])) {
                $unprocessedOperations[$key] = $instruction;

                continue;
            }

            $wires[$target] = handleShortIntOverflow($wires[$matches[1]] & (int) $matches[2]);
        } elseif (preg_match("/^(\d+)\s+AND\s+([a-z]+)$/", $instruction, $matches) === 1) { // AND with number and wire
            if (!isset($wires[$matches[2]])) {
                $unprocessedOperations[$key] = $instruction;

                continue;
            }

            $wires[$target] = handleShortIntOverflow((int) $matches[1] & (int) $wires[$matches[2]]);
        } elseif (preg_match("/^([a-z]+)\s+AND\s+([a-z]+)$/", $instruction, $matches) === 1) { // AND with wire and wire
            if (!isset($wires[$matches[1]]) || !isset($wires[$matches[2]])) {
                $unprocessedOperations[$key] = $instruction;

                continue;
            }

            $wires[$target] = handleShortIntOverflow((int) $wires[$matches[1]] & (int) $wires[$matches[2]]);
        } elseif (preg_match("/^([a-z]+)\s+OR\s+([a-z]+)$/", $instruction, $matches) === 1) { // OR with wire and wire
            if (!isset($wires[$matches[1]]) || !isset($wires[$matches[2]])) {
                $unprocessedOperations[$key] = $instruction;

                continue;
            }

            $wires[$target] = handleShortIntOverflow((int) $wires[$matches[1]] | (int) $wires[$matches[2]]);
        } elseif (preg_match("/^([a-z]+)\s+LSHIFT\s+(\d+)$/", $instruction, $matches) === 1) { // LSHIFT with wire and number
            if (!isset($wires[$matches[1]])) {
                $unprocessedOperations[$key] = $instruction;

                continue;
            }

            $wires[$target] = handleShortIntOverflow((int) $wires[$matches[1]] << (int) $matches[2]);
        } elseif (preg_match("/^([a-z]+)\s+RSHIFT\s+(\d+)$/", $instruction, $matches) === 1) { // RSHIFT with wire and number
            if (!isset($wires[$matches[1]])) {
                $unprocessedOperations[$key] = $instruction;

                continue;
            }

            $wires[$target] = handleShortIntOverflow((int) $wires[$matches[1]] >> (int) $matches[2]);
        } elseif (preg_match("/^NOT\s+([a-z]+)$/", $instruction, $matches) === 1) { // NOT with wire
            if (!isset($wires[$matches[1]])) {
                $unprocessedOperations[$key] = $instruction;

                continue;
            }

            $wires[$target] = handleShortIntOverflow(~ $wires[$matches[1]]);
        } else {
            throw new \Exception("Invalid instruction: {$instruction}");
        }

        unset ($unprocessedOperations[$key]);
    }
} while (count($unprocessedOperations) > 0);

$wireAValue = $wires["a"];
echo "Value of wire 'a' is {$wireAValue}\n";

$wires = [];
$wires["b"] = $wireAValue;


do {
    foreach ($instructions as $key => $instruction) {
        if (preg_match("/(.+)\s+->\s+([a-z]+)/", $instruction, $matches) !== 1) {
            throw new \Exception("Invalid instruction: {$instruction}");
        }

        $instruction = $matches[1];
        $target = $matches[2];
        $matches = [];

        if (preg_match("/^(\d+)$/", $instruction, $matches) === 1) { // assignment
            $wires[$target] = (int) $matches[1];
        } elseif (preg_match("/^([a-z]+)$/", $instruction, $matches) === 1) { // assignment from wire
            if (!isset($wires[$matches[1]])) {
                $unprocessedOperations[$key] = $instruction;

                continue;
            }

            $wires[$target] = $wires[$matches[1]];
        } elseif (preg_match("/^([a-z]+)\s+AND\s+(\d+)$/", $instruction, $matches) === 1) { // AND with wire and number
            if (!isset($wires[$matches[1]])) {
                $unprocessedOperations[$key] = $instruction;

                continue;
            }

            $wires[$target] = handleShortIntOverflow($wires[$matches[1]] & (int) $matches[2]);
        } elseif (preg_match("/^(\d+)\s+AND\s+([a-z]+)$/", $instruction, $matches) === 1) { // AND with number and wire
            if (!isset($wires[$matches[2]])) {
                $unprocessedOperations[$key] = $instruction;

                continue;
            }

            $wires[$target] = handleShortIntOverflow((int) $matches[1] & (int) $wires[$matches[2]]);
        } elseif (preg_match("/^([a-z]+)\s+AND\s+([a-z]+)$/", $instruction, $matches) === 1) { // AND with wire and wire
            if (!isset($wires[$matches[1]]) || !isset($wires[$matches[2]])) {
                $unprocessedOperations[$key] = $instruction;

                continue;
            }

            $wires[$target] = handleShortIntOverflow((int) $wires[$matches[1]] & (int) $wires[$matches[2]]);
        } elseif (preg_match("/^([a-z]+)\s+OR\s+([a-z]+)$/", $instruction, $matches) === 1) { // OR with wire and wire
            if (!isset($wires[$matches[1]]) || !isset($wires[$matches[2]])) {
                $unprocessedOperations[$key] = $instruction;

                continue;
            }

            $wires[$target] = handleShortIntOverflow((int) $wires[$matches[1]] | (int) $wires[$matches[2]]);
        } elseif (preg_match("/^([a-z]+)\s+LSHIFT\s+(\d+)$/", $instruction, $matches) === 1) { // LSHIFT with wire and number
            if (!isset($wires[$matches[1]])) {
                $unprocessedOperations[$key] = $instruction;

                continue;
            }

            $wires[$target] = handleShortIntOverflow((int) $wires[$matches[1]] << (int) $matches[2]);
        } elseif (preg_match("/^([a-z]+)\s+RSHIFT\s+(\d+)$/", $instruction, $matches) === 1) { // RSHIFT with wire and number
            if (!isset($wires[$matches[1]])) {
                $unprocessedOperations[$key] = $instruction;

                continue;
            }

            $wires[$target] = handleShortIntOverflow((int) $wires[$matches[1]] >> (int) $matches[2]);
        } elseif (preg_match("/^NOT\s+([a-z]+)$/", $instruction, $matches) === 1) { // NOT with wire
            if (!isset($wires[$matches[1]])) {
                $unprocessedOperations[$key] = $instruction;

                continue;
            }

            $wires[$target] = handleShortIntOverflow(~ $wires[$matches[1]]);
        } else {
            throw new \Exception("Invalid instruction: {$instruction}");
        }

        unset ($unprocessedOperations[$key]);
    }
} while (count($unprocessedOperations) > 0);


//ksort($wires);
//var_dump($wires);

echo "Second value of wire 'a' is {$wires["a"]}\n";
