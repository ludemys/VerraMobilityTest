<?php

declare(strict_types=1);

namespace App\Load;

class WordLoader
{
    private const DEFAULT_FILE_LOCATION = __DIR__ . '/../../_ref/wordlist.txt';

    private array $wordExistsMap = [];
    private array $words = [];

    public function __construct(?string $filePath = null)
    {
        $this->loadWords($filePath ?? self::DEFAULT_FILE_LOCATION);
    }

    private function loadWords(string $filePath): void
    {
        if (!is_readable($filePath)) {
            throw new \RuntimeException("Word list file $filePath is not readable");
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if ($lines === false) {
            throw new \RuntimeException("Could not read word list file $filePath");
        }

        foreach ($lines as $word) {
            $word = trim($word);

            if ($word === '') {
                continue;
            }

            $this->words[] = $word;
            $this->wordExistsMap[$word] = true;
        }
    }

    public function getWords(): array
    {
        return $this->words;
    }

    public function exists(string $word): bool
    {
        return $this->wordExistsMap[$word] ?? false;
    }
}
