<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RefreshCommand extends Command
{
    protected $signature = 'shop:fresh';

    protected $description = 'Refresh migration';

    public function handle(): int
    {
        if (!app()->isLocal())
        {
            return self::FAILURE;
        }

        Storage::deleteDirectory('images/products');
        Storage::createDirectory('images/products');
        $this->call('migrate:fresh', [
            '--seed' => true
        ]);

        return self::SUCCESS;
    }
}
