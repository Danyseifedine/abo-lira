<?php

namespace App\Console\Commands;

use App\Services\File\FileUploadService;
use Illuminate\Console\Command;

class CleanupTempFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'temp:cleanup {--hours=24 : Delete files older than specified hours}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up temporary uploaded files older than specified hours';

    public function __construct(
        private readonly FileUploadService $fileUploadService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $hours = (int) $this->option('hours');

        $this->info("Cleaning up temporary files older than {$hours} hours...");

        try {
            $deletedCount = $this->fileUploadService->cleanupOldFiles($hours);

            $this->info("Cleanup completed. Deleted {$deletedCount} temporary files.");

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Cleanup failed: ' . $e->getMessage());

            return self::FAILURE;
        }
    }
}
