<?php

namespace App\Console\Commands;

use App\Models\Repack;
use App\Services\XatabService;
use Exception;
use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class RepacksParseCategoriesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:repacks-parse-categories';

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
        $xatabService = new XatabService();

//        $xatabService->parseAllCategories();
//        $xatabService->parseCategory('https://byxatab.com/torrent_igry/rpg/');
        $xatabService->parseGame('https://byxatab.com/games/torrent_igry/rpg/horizon-zero-dawn-remastered-2024/2-1-0-3525');



        $test = new Repack('TeSt');

        $this->sendCompletionReportToTelegram();
        dd($test->requirements);
    }

    /**
     * Send completion report to Telegram chat.
     */
    private function sendCompletionReportToTelegram(): void
    {
        try {
            Telegram::sendMessage([
                'chat_id' => config('telegram.bots.telegram_bot.chat_id'),
                'text' => 'Job: Repack parsing finished successfully!',
            ]);
            dump('Report sent to Telegram');
        } catch (Exception $e) {
            dump('An error occurred while sending report to Telegram: ', $e->getMessage());
        }
    }
}
