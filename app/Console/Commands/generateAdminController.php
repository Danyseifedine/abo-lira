<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class generateAdminController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:controller {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new admin controller';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');

        $controller = `php artisan make:controller SuperAdmin/{$name}Controller --resource`;

        exec($controller);

        $this->info('Controller created successfully: ' . $controller);
    }
}
