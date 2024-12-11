<?php

namespace App\Console\Commands;

use App\Models\Repack;
use Illuminate\Console\Command;

class RepacksParseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:repacks-parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle() {
        $test = new Repack('TeSt');

        dd($test->requirements);
    }
}
