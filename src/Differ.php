<?php

namespace Hexlet\Code;

use function Funct\Collection\sortBy;

function genDiff(string $filePath1, string $filePath2): string
{
    $data1 = parseJsonFile($filePath1);
    $data2 = parseJsonFile($filePath2);

    $keys1 = array_keys(get_object_vars($data1));
    $keys2 = array_keys(get_object_vars($data2));
    $allKeys = array_unique(array_merge($keys1, $keys2));

    $sortedKeys = sortBy($allKeys, function ($key) {
        return $key;
    });

    $lines = [];
    foreach ($sortedKeys as $key) {
        $has1 = property_exists($data1, $key);
        $has2 = property_exists($data2, $key);
        $value1 = $has1 ? $data1->$key : null;
        $value2 = $has2 ? $data2->$key : null;

        if (!$has1) {
            $lines[] = "  + {$key}: " . formatValue($value2);
        } elseif (!$has2) {
            $lines[] = "  - {$key}: " . formatValue($value1);
        } elseif ($value1 !== $value2) {
            $lines[] = "  - {$key}: " . formatValue($value1);
            $lines[] = "  + {$key}: " . formatValue($value2);
        } else {
            $lines[] = "    {$key}: " . formatValue($value1);
        }
    }

    return "{\n" . implode("\n", $lines) . "\n}";
}

function formatValue($value): string
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (is_null($value)) {
        return 'null';
    }
    if (is_string($value)) {
        return $value; // без кавычек
    }
    return (string) $value;
}
