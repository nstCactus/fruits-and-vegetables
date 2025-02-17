<?php

namespace App\Command;

use App\Exception\ImportException;
use App\Service\CommandHelper;
use App\Service\ImportEdiblesService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:import:edibles',
    description: 'Import fruits & vegetables from a JSON file',
)]
class ImportEdiblesCommand extends Command
{
    public function __construct(
        private readonly ImportEdiblesService $importEdiblesService,
        private readonly CommandHelper $commandHelper,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('file', InputArgument::REQUIRED, 'JSON file to import');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $path = $this->commandHelper->getStringArgument($input, 'file');
        $io->note("Importing from: $path");

        try {
            $this->importEdiblesService->import($path);
        } catch (ImportException $e) {
            $io->error("Import failed: {$e->getMessage()}");
            return Command::FAILURE;
        }

        $io->success('Import successful.');

        return Command::SUCCESS;
    }
}
