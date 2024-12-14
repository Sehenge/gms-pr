<?php

namespace App\Console\Commands;

use App\Models\Repack;
use App\Models\RepackCategory;
use App\Services\XatabService;
use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class RepacksParseCategoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:repacks-parse-category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $repackCategories = RepackCategory::all();

        $xatabService = new XatabService();

        foreach ($repackCategories as $repackCategory) {
            $xatabService->parseCategory($repackCategory);

            $repackCategory->parsed = true;
            $repackCategory->save();

            die();
        }

        $this->sendCompletionReportToTelegram();

    }

    private function sendCompletionReportToTelegram(): void //TODO: MOVE TO SERVICE
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
