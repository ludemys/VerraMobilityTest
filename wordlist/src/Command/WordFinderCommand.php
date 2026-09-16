<?php

declare(strict_types=1);

namespace App\Command;

use App\Find\WordFinder;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:find-words')]
final class WordFinderCommand
{
    public function __construct (
        private readonly WordFinder $wordFinder,
    ) {
    }

    public function __invoke(OutputInterface $output): int
    {
        try {
            $foundWords = $this->wordFinder->findWords();
        } catch (\RuntimeException) {
            $output->writeLn('File could not be read');
            return Command::FAILURE;
        }

        $output->writeLn(implode(PHP_EOL, $foundWords));

        return Command::SUCCESS;
    }
}
