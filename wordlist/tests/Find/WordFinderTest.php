<?php

declare(strict_types=1);

namespace App\Tests\Find;

use App\Find\WordFinder;
use App\Load\WordLoader;
use PHPUnit\Framework\TestCase;

final class WordFinderTest extends TestCase
{
    public function testItFindsSixLetterWordsMadeFromTwoKnownWords(): void
    {
        $words = ['action', 'foobar', 'planet', 'short', 'toolong'];
        $knownWords = ['act', 'ion', 'foo', 'bar'];

        $wordLoader = $this->createMock(WordLoader::class);
        $wordLoader
            ->method('getWords')
            ->willReturn($words);
        $wordLoader
            ->method('exists')
            ->willReturnCallback(
                static fn (string $word): bool => in_array($word, $knownWords, true),
            );

        $finder = new WordFinder($wordLoader);

        self::assertSame(
            [
                'act + ion => action',
                'foo + bar => foobar',
            ],
            $finder->findWords(),
        );
    }
}
