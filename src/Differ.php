<?php

namespace Hexlet\Code;

use function Funct\Collection\sortBy;
use function Hexlet\Code\formatDiff;

function genDiff(string $filePath1, string $filePath2, string $format = 'stylish'): string
{
    $data1 = parseFile($filePath1);
    $data2 = parseFile($filePath2);
    $diffTree = buildDiff($data1, $data2);
    return formatDiff($diffTree, $format);
}

function buildDiff(object $data1, object $data2): array
{
    $keys = array_unique(array_merge(
        array_keys(get_object_vars($data1)),
        array_keys(get_object_vars($data2))
    ));
    $keys = sortBy($keys, fn($key) => $key);

    $result = [];
    foreach ($keys as $key) {
        $has1 = property_exists($data1, $key);
        $has2 = property_exists($data2, $key);
        $value1 = $has1 ? $data1->$key : null;
        $value2 = $has2 ? $data2->$key : null;

        if (!$has1) {
            $result[] = [
                'key' => $key,
                'type' => 'added',
                'newValue' => $value2,
            ];
        } elseif (!$has2) {
            $result[] = [
                'key' => $key,
                'type' => 'removed',
                'oldValue' => $value1,
            ];
        } elseif (is_object($value1) && is_object($value2) &&
                  !empty(get_object_vars($value1)) && !empty(get_object_vars($value2))) {
            $result[] = [
                'key' => $key,
                'type' => 'nested',
                'children' => buildDiff($value1, $value2),
            ];
        } elseif ($value1 !== $value2) {
            $result[] = [
                'key' => $key,
                'type' => 'changed',
                'oldValue' => $value1,
                'newValue' => $value2,
            ];
        } else {
            $result[] = [
                'key' => $key,
                'type' => 'unchanged',
                'oldValue' => $value1,
            ];
        }
    }
    return $result;
}
