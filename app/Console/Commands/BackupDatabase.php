<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class BackupDatabase extends Command
{
    protected $signature = 'laundry:backup';
    protected $description = 'Backup SQLite database';

    public function handle()
    {
        $source = database_path("database.sqlite");
        $dest = storage_path("backups/database_" . date("Ymd_His") . ".sqlite");
        
        if (!File::exists(storage_path("backups"))) File::makeDirectory(storage_path("backups"));
        
        if (File::exists($source)) {
            File::copy($source, $dest);
            $this->info("Backup created: " . basename($dest));
        } else {
            $this->error("Database file not found!");
        }
    }
}
