<?php

namespace Differ\Formatters\Json;

function jsonFormat(array $diffTree): string
{
    $normalized = normalizeTree($diffTree);
    return json_encode($normalized, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
}

function normalizeTree(array $nodes): array
{
    $result = [];
    foreach ($nodes as $node) {
        $item = [
            'key' => $node['key'],
            'type' => $node['type'],
        ];
        if (array_key_exists('children', $node)) {
            $item['children'] = normalizeTree($node['children']);
        }
        if (array_key_exists('oldValue', $node)) {
            $item['oldValue'] = normalizeValue($node['oldValue']);
        }
        if (array_key_exists('newValue', $node)) {
            $item['newValue'] = normalizeValue($node['newValue']);
        }
        $result[] = $item;
    }
    return $result;
}

function normalizeValue($value)
{
    if (is_object($value) || is_array($value)) {
        return '[complex value]';
    }
    return $value;
}
