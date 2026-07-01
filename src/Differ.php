<?php

namespace Differ\Differ;

use function Funct\Collection\sortBy;
use function Differ\Formatters\formatDiff;

function genDiff(string $filePath1, string $filePath2, string $format = 'stylish'): string
{
    $content1 = file_get_contents($filePath1);
    $content2 = file_get_contents($filePath2);
    $extension1 = pathinfo($filePath1, PATHINFO_EXTENSION);
    $extension2 = pathinfo($filePath2, PATHINFO_EXTENSION);

    $data1 = \Differ\Parsers\parse($content1, $extension1);
    $data2 = \Differ\Parsers\parse($content2, $extension2);

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

    $result = array_map(function ($key) use ($data1, $data2) {
        $has1 = property_exists($data1, $key);
        $has2 = property_exists($data2, $key);
        $value1 = $has1 ? $data1->$key : null;
        $value2 = $has2 ? $data2->$key : null;

        if (!$has1) {
            return ['key' => $key, 'type' => 'added', 'newValue' => $value2];
        }
        if (!$has2) {
            return ['key' => $key, 'type' => 'removed', 'oldValue' => $value1];
        }
        if (
            is_object($value1) && is_object($value2) &&
            !empty(get_object_vars($value1)) && !empty(get_object_vars($value2))
        ) {
            return ['key' => $key, 'type' => 'nested', 'children' => buildDiff($value1, $value2)];
        }
        if ($value1 !== $value2) {
            return ['key' => $key, 'type' => 'changed', 'oldValue' => $value1, 'newValue' => $value2];
        }
        return ['key' => $key, 'type' => 'unchanged', 'oldValue' => $value1];
    }, $keys);

    return array_values($result);
}
