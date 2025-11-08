<?php

namespace Modules\ModuleManager\Console;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class ModuleComposerCommand extends Command
{
    protected $signature = 'modules:update-composer';
    protected $description = 'Merge modules composer configurations using composer-merge-plugin';

    public function handle()
    {
        try {

            ini_set('memory_limit', '-1');
            set_time_limit(900);

            $composerBinary = $this->getAvailableComposerBinary(); // 'composer2' or 'composer'

            $process = new Process([$composerBinary, 'update', '--no-interaction']);
            $process->setWorkingDirectory(base_path());
            $process->setTimeout(900); // optional: increase for large updates
            $process->run();

            if (!$process->isSuccessful()) {
                throw new \RuntimeException($process->getErrorOutput());
            }

            $this->info($process->getOutput());
            return Command::SUCCESS;

        } catch (\Throwable $e) {
            $this->error("Composer update failed: " . $e->getMessage());
            return Command::FAILURE;
        }
    }

    protected function getAvailableComposerBinary(): string
    {
        // 1. Check .env override
        $envBinary = env('COMPOSER_BINARY');
        if ($envBinary) {
            return $envBinary;
        }

        // 2. Define binaries and file extensions
        $binaryNames = ['composer2', 'composer'];
        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
        $extensions = $isWindows ? ['', '.bat', '.phar'] : [''];
        $whichCommand = $isWindows ? 'where' : 'which';

        // 3. Loop through all combinations to find a valid executable
        foreach ($binaryNames as $binary) {
            foreach ($extensions as $ext) {
                $fullBinary = $binary . $ext;

                try {
                    $process = new Process([$whichCommand, $fullBinary]);
                    $process->run();

                    if ($process->isSuccessful()) {
                        $output = trim($process->getOutput());
                        $path = strtok($output, PHP_EOL); // Get first line
                        if ($path) {
                            return $path;
                        }
                    }
                } catch (\Throwable $e) {
                    // Skip and try next
                }
            }
        }

        // 4. No valid composer binary found
        throw new \RuntimeException(
            'No valid Composer binary found. ' .
            'Ensure Composer is installed and available in your PATH, ' .
            'or define a full path using COMPOSER_BINARY in your .env file.'
        );
    }

}
