<?php

declare(strict_types = 1);

$handle = fopen("input.txt", "r");


while (($line = fgets($handle)) !== false) {
    preg_match('/^(\w+)\s+to\s+(\w+)\s+=\s+(\d+)$/', $line, $matches);

    var_dump($matches);

}

fclose($handle);
