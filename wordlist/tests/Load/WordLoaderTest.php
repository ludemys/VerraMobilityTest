<?php

declare(strict_types=1);

namespace App\Tests\Load;

use App\Load\WordLoader;
use PHPUnit\Framework\TestCase;

final class WordLoaderTest extends TestCase
{
    public function testItLoadsWordsAndBuildsTheExistenceMap(): void
    {
        $loader = new WordLoader(__DIR__ . '/../Fixtures/wordlist.txt');

        self::assertSame(
            ['act', 'ion', 'action', 'foo', 'bar', 'foobar'],
            $loader->getWords(),
        );
        self::assertTrue($loader->exists('action'));
        self::assertTrue($loader->exists('foo'));
        self::assertFalse($loader->exists('missing'));
    }

    public function testItRejectsAnUnreadableFile(): void
    {
        $missingFile = __DIR__ . '/../Fixtures/missing.txt';

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage("Word list file $missingFile is not readable");

        new WordLoader($missingFile);
    }
}
