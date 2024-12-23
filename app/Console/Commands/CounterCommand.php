<?php

namespace App\Console\Commands;

use App\Models\Repack;
use App\Models\Statistic;
use App\Services\TelegramService;
use App\Services\XatabService;
use Illuminate\Console\Command;

class CounterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:counter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sal counter';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        while (true) {
            $statistic = new Statistic();
            $statistic->startCount();

            sleep(60);
        }
    }
}
