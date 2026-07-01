<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse(string $content, string $extension): object
{
    return match ($extension) {
        'json' => parseJson($content),
        'yml', 'yaml' => parseYaml($content),
        default => throw new \Exception("Unsupported file format: {$extension}")
    };
}

function parseJson(string $content): object
{
    $data = json_decode($content);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new \Exception("Invalid JSON: " . json_last_error_msg());
    }
    return $data;
}

function parseYaml(string $content): object
{
    return Yaml::parse($content, Yaml::PARSE_OBJECT_FOR_MAP);
}
