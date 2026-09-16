<?php

declare(strict_types=1);

namespace App\Find;

use App\Load\WordLoader;

final readonly class WordFinder
{
    private const FINDABLE_WORDS_LENGTH = 6;

    public function __construct (
        private WordLoader $wordloader,
    ) {

    }

    public function findWords(): array
    {
        $words = [];

        foreach ($this->wordloader->getWords() as $word) {
            if (strlen($word) !== self::FINDABLE_WORDS_LENGTH) {
                continue;
            }

            for ($i = 1; $i < self::FINDABLE_WORDS_LENGTH; $i++) {
                $leftSide = substr($word, 0, $i);
                $rightSide = substr($word, $i);

                if ($this->wordloader->exists($leftSide) && $this->wordloader->exists($rightSide)) {
                    $words[] = "$leftSide + $rightSide => $word";
                }
            }
        }

        return $words;
    }
}