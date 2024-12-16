<?php

namespace App\Console\Commands;

use App\Models\Repack;
use App\Services\TelegramService;
use App\Services\XatabService;
use Illuminate\Console\Command;

class RepacksParseGamesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:repacks-parse-games';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $games = Repack::where('parsed', false)->get();

        $xatabService = new XatabService();

        foreach ($games as $game) {
            $xatabService->parseGame(game: $game);
        }
    }
}
