<?php

namespace App\Services;

use App\Models\Repack;
use Exception;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramService
{
    /**
     * Send completion report to Telegram chat.
     */
    public static function sendCompletionReportToTelegram(Repack $repack): void
    {
        try {
            $filename = explode('/', $repack->image);
            $image = InputFile::createFromContents(
                file_get_contents(config('repacks.source.xatab') . $repack->image),
                end($filename),
            );

            Telegram::sendPhoto([
                'chat_id' => config('telegram.bots.telegram_bot.chat_id'),
                'photo' => $image,
                'caption' => self::prepareCaption($repack),
                'parse_mode' => 'HTML',
            ]);

            dump('--- Posted: ' . $repack->title);
        } catch (Exception $e) {
            dump('An error occurred while sending report to Telegram: ', $e->getMessage());
        }
    }

    /**
     * @param Repack $repack
     * @return string
     */
    private static function prepareCaption(Repack $repack): string
    {
        $fileUrl = str_replace('&', '&amp;', $repack->file);

        $caption = '<b>'
        . $repack->title
        . "</b>\n\n"
        . substr($repack->description, 0, 800) . '...' . "\n\n"
        . $fileUrl; //TODO: change to UTF-8? Need to fix

        return $caption;
    }
}