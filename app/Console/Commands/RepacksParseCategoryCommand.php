<?php

namespace App\Console\Commands;

use App\Models\Repack;
use App\Models\RepackCategory;
use App\Services\TelegramService;
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
    public function handle(TelegramService $telegramService): void
    {
        $repackCategories = RepackCategory::all();

        $xatabService = new XatabService();

        foreach ($repackCategories as $repackCategory) {
            $xatabService->parseCategory(category: $repackCategory);

            $repackCategory->parsed = true;
            $repackCategory->save();

            die();
        }

        $telegramService->sendCompletionReportToTelegram();
    }
}
