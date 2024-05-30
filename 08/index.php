<?php

declare(strict_types = 1);

$handle = fopen("input.txt", "r");
$strings = [];
$totalLength = 0;
$totalCharacterLength = 0;
$totalEncodedLength = 0;

while (($line = fgets($handle)) !== false) {
    $line = trim($line);
    $totalEncodedLength += strlen(encode($line));
    $totalCharacterLength += strlen(decode($line));
    $totalLength += (strlen($line));
}

fclose($handle);

echo "1: Difference is {$totalLength} - {$totalCharacterLength} = " . ($totalLength - $totalCharacterLength) . "\n";
echo "2: Difference is {$totalEncodedLength} - {$totalLength} = " . ($totalEncodedLength - $totalLength) . "\n";

function decode(string $string): string {
    $string = ltrim($string, '"');
    $string = rtrim($string, '"');
    $string = str_replace("\\\"", "\"", $string);
    $string = str_replace("\\\\", "\\", $string);

    return preg_replace_callback("/\\\\x([0-9a-f]{2})/", fn ($matches) => chr(hexdec($matches[1])), $string);
}

function encode(string $string): string {
    $string = str_replace("\\", "\\\\", $string);
    $string = str_replace("\"", "\\\"", $string);

    return "\"" . $string . "\"";
}
