<?php

namespace Differ\Formatters\Stylish;

function stylish(array $diffTree, int $depth = 1): string
{
    $lines = array_map(function ($node) use ($depth) {
        $indent = str_repeat(' ', $depth * 4);
        $indentWithSign = str_repeat(' ', $depth * 4 - 2);
        $key = $node['key'];

        return match ($node['type']) {
            'nested' => implode("\n", [
                "{$indent}{$key}: {",
                stylish($node['children'], $depth + 1),
                "{$indent}}"
            ]),
            'added' => "{$indentWithSign}+ {$key}: " . stringify($node['newValue'], $depth + 1),
            'removed' => "{$indentWithSign}- {$key}: " . stringify($node['oldValue'], $depth + 1),
            'changed' => implode("\n", [
                "{$indentWithSign}- {$key}: " . stringify($node['oldValue'], $depth + 1),
                "{$indentWithSign}+ {$key}: " . stringify($node['newValue'], $depth + 1)
            ]),
            'unchanged' => "{$indent}{$key}: " . stringify($node['oldValue'], $depth + 1),
            default => throw new \Exception("Unknown node type: {$node['type']}")
        };
    }, $diffTree);

    return implode("\n", $lines);
}

function stringify($value, int $depth): string
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
        $lines = ['{'];
        foreach ($vars as $k => $v) {
            $lines[] = str_repeat(' ', $depth * 4) . "{$k}: " . stringify($v, $depth + 1);
        }
        $lines[] = str_repeat(' ', ($depth - 1) * 4) . '}';
        return implode("\n", $lines);
    }
    return (string) $value;
}
