<?php

namespace Hexlet\Code;

function parseJsonFile(string $filePath): object
{
    if (!file_exists($filePath)) {
        throw new \Exception("File not found: $filePath");
    }

    $content = file_get_contents($filePath);
    if ($content === false) {
        throw new \Exception("Could not read file: $filePath");
    }

    $data = json_decode($content);
    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        throw new \Exception("Invalid JSON: " . json_last_error_msg());
    }

    return $data;
}
