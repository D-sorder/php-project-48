<?php

namespace Hexlet\Code;

use function Hexlet\Code\Formatters\stylish;
use function Hexlet\Code\Formatters\plain;
use function Hexlet\Code\Formatters\json as jsonFormat;

function formatDiff(array $diffTree, string $format): string
{
    switch ($format) {
        case 'stylish':
            return "{\n" . stylish($diffTree) . "\n}";
        case 'plain':
            return plain($diffTree);
        case 'json':
            return jsonFormat($diffTree);
        default:
            throw new \Exception("Unsupported format: {$format}");
    }
}
