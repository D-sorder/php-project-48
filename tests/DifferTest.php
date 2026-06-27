<?php

namespace Hexlet\Code\Tests;

use PHPUnit\Framework\TestCase;

use function Hexlet\Code\genDiff;

class DifferTest extends TestCase
{
    public function testGenDiff(): void
    {
        $fixturesPath = __DIR__ . '/fixtures';
        $file1 = $fixturesPath . '/file1.json';
        $file2 = $fixturesPath . '/file2.json';
        $expected = file_get_contents($fixturesPath . '/expected_diff.txt');

        $actual = genDiff($file1, $file2);

        $this->assertEquals(trim($expected), trim($actual));
    }

    public function testGenDiffForYaml(): void
    {
        $fixturesPath = __DIR__ . '/fixtures';
	$file1 = $fixturesPath . '/file1.yml';
        $file2 = $fixturesPath . '/file2.yml';
        $expected = file_get_contents($fixturesPath . '/expected_diff.txt');

        $actual = genDiff($file1, $file2);

        $this->assertEquals(trim($expected), trim($actual));
    }

    public function testGenDiffForNestedJson(): void
    {
        $fixturesPath = __DIR__ . '/fixtures';
        $file1 = $fixturesPath . '/file1_nested.json';
        $file2 = $fixturesPath . '/file2_nested.json';
        $expected = file_get_contents($fixturesPath . '/expected_nested_diff.txt');

        $actual = genDiff($file1, $file2);
        $this->assertEquals(trim($expected), trim($actual));
    }

    public function testGenDiffForNestedYaml(): void
    {
        $fixturesPath = __DIR__ . '/fixtures';
        $file1 = $fixturesPath . '/file1_nested.yml';
        $file2 = $fixturesPath . '/file2_nested.yml';
        $expected = file_get_contents($fixturesPath . '/expected_nested_diff.txt');

        $actual = genDiff($file1, $file2);
        $this->assertEquals(trim($expected), trim($actual));
    }

    public function testGenDiffPlainForNestedJson(): void
    {
        $fixturesPath = __DIR__ . '/fixtures';
        $file1 = $fixturesPath . '/file1_nested.json';
        $file2 = $fixturesPath . '/file2_nested.json';
        $expected = file_get_contents($fixturesPath . '/expected_plain_diff.txt');

        $actual = genDiff($file1, $file2, 'plain');
        $this->assertEquals(trim($expected), trim($actual));
    }

    public function testGenDiffPlainForNestedYaml(): void
    {
        $fixturesPath = __DIR__ . '/fixtures';
        $file1 = $fixturesPath . '/file1_nested.yml';
        $file2 = $fixturesPath . '/file2_nested.yml';
        $expected = file_get_contents($fixturesPath . '/expected_plain_diff.txt');

        $actual = genDiff($file1, $file2, 'plain');
        $this->assertEquals(trim($expected), trim($actual));
    }

    public function testGenDiffJsonForNestedJson(): void
    {
        $fixturesPath = __DIR__ . '/fixtures';
        $file1 = $fixturesPath . '/file1_nested.json';
        $file2 = $fixturesPath . '/file2_nested.json';
        $expected = file_get_contents($fixturesPath . '/expected_json_diff.json');

        $actual = genDiff($file1, $file2, 'json');
        $this->assertEquals(trim($expected), trim($actual));
    }

    public function testGenDiffJsonForNestedYaml(): void
    {
        $fixturesPath = __DIR__ . '/fixtures';
        $file1 = $fixturesPath . '/file1_nested.yml';
        $file2 = $fixturesPath . '/file2_nested.yml';
        $expected = file_get_contents($fixturesPath . '/expected_json_diff.json');

        $actual = genDiff($file1, $file2, 'json');
        $this->assertEquals(trim($expected), trim($actual));
    }
}
