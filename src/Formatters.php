<?php

namespace Differ\Formatters;

use function Differ\Formatters\Stylish\stylish;
use function Differ\Formatters\Plain\plain;
use function Differ\Formatters\Json\jsonFormat;

function formatDiff(array $diffTree, string $format): string
{
    return match ($format) {
        'stylish' => "{\n" . stylish($diffTree) . "\n}\n",
        'plain'   => plain($diffTree) . "\n",
        'json'    => jsonFormat($diffTree),
        default   => throw new \Exception("Unsupported format: {$format}")
    };
}
