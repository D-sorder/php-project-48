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
}
