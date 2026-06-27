<?php

namespace Hexlet\Code;

use Symfony\Component\Yaml\Yaml;

function parseFile(string $filePath): object
{
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);

    $content = file_get_contents($filePath);
    if ($content === false) {
        throw new \Exception("Could not read file: $filePath");
    }

    return match ($extension) {
        'json' => parseJson($content),
        'yml', 'yaml' => parseYaml($content),
        default => throw new \Exception("Unsupported file format: $extension"),
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
