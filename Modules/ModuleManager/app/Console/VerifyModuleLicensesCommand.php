<?php

namespace Modules\ModuleManager\Console;

use Illuminate\Console\Command;
use Modules\ModuleManager\Services\ModuleManager;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class VerifyModuleLicensesCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:verify-licenses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify licenses for all installed modules with purchase codes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(ModuleManager $moduleManager)
    {
        $this->info('Verifying module licenses...');
        
        if (!config('module_manager.envato_api_token')) {
            $this->error('Envato API token is not configured. Please set it in your module_manager config.');
            return 1;
        }
        
        $results = $moduleManager->verifyLicenses();
        
        if (isset($results['error'])) {
            $this->error($results['error']);
            return 1;
        }
        
        if (empty($results)) {
            $this->info('No module licenses found to verify.');
            return 0;
        }
        
        $this->info('License verification results:');
        
        $headers = ['Module', 'Status', 'Valid Until', 'Message'];
        $rows = [];
        
        foreach ($results as $module => $result) {
            $rows[] = [
                $module,
                $result['status'],
                $result['valid_until'] ?? 'N/A',
                $result['message'] ?? 'N/A',
            ];
        }
        
        $this->table($headers, $rows);
        
        return 0;
    }
}