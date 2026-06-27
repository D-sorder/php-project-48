<?php

namespace Differ\Differ\Formatters;

function stylish(array $diffTree, int $depth = 1): string
{
    $lines = [];
    $indent = str_repeat(' ', $depth * 4);
    $indentWithSign = str_repeat(' ', $depth * 4 - 2);

    foreach ($diffTree as $node) {
        $key = $node['key'];
        switch ($node['type']) {
            case 'nested':
                $children = stylish($node['children'], $depth + 1);
                $lines[] = "{$indent}{$key}: {";
                $lines[] = $children;
                $lines[] = "{$indent}}";
                break;
            case 'added':
                $value = stringifyValue($node['newValue'], $depth + 1);
                $lines[] = "{$indentWithSign}+ {$key}: {$value}";
                break;
            case 'removed':
                $value = stringifyValue($node['oldValue'], $depth + 1);
                $lines[] = "{$indentWithSign}- {$key}: {$value}";
                break;
            case 'changed':
                $oldValue = stringifyValue($node['oldValue'], $depth + 1);
                $newValue = stringifyValue($node['newValue'], $depth + 1);
                $lines[] = "{$indentWithSign}- {$key}: {$oldValue}";
                $lines[] = "{$indentWithSign}+ {$key}: {$newValue}";
                break;
            case 'unchanged':
                $value = stringifyValue($node['oldValue'], $depth + 1);
                $lines[] = "{$indent}{$key}: {$value}";
                break;
            default:
                throw new \Exception("Unknown node type: {$node['type']}");
        }
    }
    return implode("\n", $lines);
}

function stringifyValue($value, int $depth): string
{
    if (is_null($value)) {
        return 'null';
    }
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (is_string($value)) {
        return $value;
    }
    if (is_object($value)) {
        $vars = get_object_vars($value);
        if (empty($vars)) {
            return '{}';
        }
        $lines = [];
        $indent = str_repeat(' ', $depth * 4);
        $lines[] = '{';
        foreach ($vars as $k => $v) {
            $val = stringifyValue($v, $depth + 1);
            $lines[] = "{$indent}{$k}: {$val}";
        }
        $lines[] = str_repeat(' ', ($depth - 1) * 4) . '}';
        return implode("\n", $lines);
    }
    return (string) $value;
}
