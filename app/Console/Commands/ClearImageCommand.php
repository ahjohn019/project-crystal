<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ClearImageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:clear-image-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear Images include files and database (Banner & Posts)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        if (app()->isLocal()) {
            $storageDisk = Storage::disk('public');
            $modelList = ['banners', 'posts', 'server_files'];

            foreach ($modelList as $model) {
                DB::table($model)->truncate();
            }

            $allFiles = $storageDisk->allFiles();
            $storageDisk->delete($allFiles);

            $this->info("Clear All Images Successfully!");
        }
    }
}
