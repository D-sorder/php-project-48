<?php

namespace Hexlet\Code\Formatters;

function json(array $diffTree): string
{
    $data = formatNode($diffTree);
    return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}

function formatNode(array $nodes): array
{
    $result = [];
    foreach ($nodes as $node) {
        $item = [
            'key' => $node['key'],
            'type' => $node['type'],
        ];

        switch ($node['type']) {
            case 'nested':
                $item['children'] = formatNode($node['children']);
                break;
            case 'added':
                $item['newValue'] = normalizeValue($node['newValue']);
                break;
            case 'removed':
                $item['oldValue'] = normalizeValue($node['oldValue']);
                break;
            case 'changed':
                $item['oldValue'] = normalizeValue($node['oldValue']);
                $item['newValue'] = normalizeValue($node['newValue']);
                break;
            case 'unchanged':
                $item['oldValue'] = normalizeValue($node['oldValue']);
                break;
            default:
                throw new \Exception("Unknown node type: {$node['type']}");
        }

        $result[] = $item;
    }
    return $result;
}

function normalizeValue($value)
{
    if (is_object($value)) {
        return '[complex value]';
    }
    if (is_array($value)) {
        return '[complex value]';
    }
    return $value;
}
