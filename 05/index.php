<?php

declare(strict_types = 1);

require_once 'String1.php';
require_once 'String2.php';

$numberOfNiceStringsOne = 0;
$numberOfNiceStringsTwo = 0;

$handle = fopen("input.txt", "r");

while (($line = fgets($handle)) !== false) {
    $string1 = new String1($line);
    $string2 = new String2($line);

    if ($string1->isNice()) {
        $numberOfNiceStringsOne++;
    }

    if ($string2->isNice()) {
        $numberOfNiceStringsTwo++;
    }
}

fclose($handle);

echo "Number of nice strings for first case is {$numberOfNiceStringsOne}, for second case {$numberOfNiceStringsTwo}" . PHP_EOL;
