<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class PulisciProgetto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pulisci-progetto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Clear caches
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('route:clear');
        $this->call('view:clear');
        $this->call('log-viewer:clear',['--no-interaction' => true]);

        $this->info('Project cleaned successfully!');
    }

    /**
     * Remove the specified folder.
     *
     * @param string $folder
     */
    protected function removeFolder($folder)
    {
        if (File::exists(base_path($folder))) {
            File::deleteDirectory(base_path($folder));
            $this->info("Removed folder: $folder");
        } else {
            $this->info("Folder not found: $folder");
        }
    }
}
