<?php

namespace App\Console\Commands;

use App\Models\Repack;
use App\Services\XatabService;
use Exception;
use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

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
    public function handle() {
        $gamesUrls = Repack::all()->pluck('repack_url')->toArray();

        $xatabService = new XatabService();

        foreach ($gamesUrls as $gameUrl) {
            $xatabService->parseGame($gameUrl);
        }

        $this->sendCompletionReportToTelegram();
    }

    /**
     * Send completion report to Telegram chat.
     */
    private function sendCompletionReportToTelegram(): void
    {
        try {
            Telegram::sendMessage([
                'chat_id' => config('telegram.bots.telegram_bot.chat_id'),
                'text' => 'Job: Repack categories parsing finished successfully!',
            ]);
            dump('Report sent to Telegram');
        } catch (Exception $e) {
            dump('An error occurred while sending report to Telegram: ', $e->getMessage());
        }
    }
}
