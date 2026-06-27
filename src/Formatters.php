<?php

namespace Differ\Differ;

use function Differ\Differ\Formatters\stylish;
use function Differ\Differ\Formatters\plain;
use function Differ\Differ\Formatters\json as jsonFormat;

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
