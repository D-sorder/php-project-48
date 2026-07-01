<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    private function getFixturePath(string $filename): string
    {
        return __DIR__ . '/fixtures/' . $filename;
    }

    #[DataProvider('diffProvider')]
    public function testGenDiff(string $format, string $file1, string $file2, string $expectedFile): void
    {
        $actual = genDiff(
            $this->getFixturePath($file1),
            $this->getFixturePath($file2),
            $format
        );

        $this->assertStringEqualsFile(
            $this->getFixturePath($expectedFile),
            $actual
        );
    }

    public static function diffProvider(): array
    {
        return [
            'stylish json' => ['stylish', 'file1_nested.json', 'file2_nested.json', 'expected_nested_diff.txt'],
            'stylish yaml' => ['stylish', 'file1_nested.yml', 'file2_nested.yml', 'expected_nested_diff.txt'],
            'plain json'   => ['plain', 'file1_nested.json', 'file2_nested.json', 'expected_plain_diff.txt'],
            'plain yaml'   => ['plain', 'file1_nested.yml', 'file2_nested.yml', 'expected_plain_diff.txt'],
            'json json'    => ['json', 'file1_nested.json', 'file2_nested.json', 'expected_json_diff.json'],
            'json yaml'    => ['json', 'file1_nested.yml', 'file2_nested.yml', 'expected_json_diff.json'],
            'default json' => ['stylish', 'file1_nested.json', 'file2_nested.json', 'expected_nested_diff.txt'],
            'default yaml' => ['stylish', 'file1_nested.yml', 'file2_nested.yml', 'expected_nested_diff.txt'],
        ];
    }
}
