<?php

namespace Hexlet\Code\Formatters;

function plain(array $diffTree, string $path = ''): string
{
    $lines = [];

    foreach ($diffTree as $node) {
        $key = $node['key'];
        $currentPath = $path ? "{$path}.{$key}" : $key;

        switch ($node['type']) {
            case 'nested':
                $lines[] = plain($node['children'], $currentPath);
                break;
            case 'added':
                $value = stringifyPlainValue($node['newValue']);
                $lines[] = "Property '{$currentPath}' was added with value: {$value}";
                break;
            case 'removed':
                $lines[] = "Property '{$currentPath}' was removed";
                break;
            case 'changed':
                $oldValue = stringifyPlainValue($node['oldValue']);
                $newValue = stringifyPlainValue($node['newValue']);
                $lines[] = "Property '{$currentPath}' was updated. From {$oldValue} to {$newValue}";
                break;
            case 'unchanged':
                // ничего не выводим
                break;
            default:
                throw new \Exception("Unknown node type: {$node['type']}");
        }
    }

    return implode("\n", array_filter($lines));
}

function stringifyPlainValue($value): string
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
