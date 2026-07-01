<?php

namespace Differ\Formatters\Plain;

function plain(array $diffTree, string $path = ''): string
{
    $lines = array_filter(array_map(function ($node) use ($path) {
        $key = $node['key'];
        $currentPath = $path ? "{$path}.{$key}" : $key;

        return match ($node['type']) {
            'nested' => plain($node['children'], $currentPath),
            'added' => "Property '{$currentPath}' was added with value: " . stringifyPlain($node['newValue']),
            'removed' => "Property '{$currentPath}' was removed",
            'changed' => sprintf(
                "Property '%s' was updated. From %s to %s",
                $currentPath,
                stringifyPlain($node['oldValue']),
                stringifyPlain($node['newValue'])
            ),
            'unchanged' => null,
            default => throw new \Exception("Unknown node type: {$node['type']}")
        };
    }, $diffTree));

    return implode("\n", $lines);
}

function stringifyPlain($value): string
{
    if (is_null($value)) {
        return 'null';
    }
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (is_string($value)) {
        return "'{$value}'";
    }
    if (is_object($value)) {
        return '[complex value]';
    }
    return (string) $value;
}
