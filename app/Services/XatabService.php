<?php

namespace App\Services;

use App\Models\Repack;
use App\Models\RepackCategory;
use PHPHtmlParser\Dom;

class XatabService
{
    private string $url;

    public function __construct()
    {
        $this->url = config('repacks.source.xatab');
    }

    private function storeCategoryInDatabase(string $category)
    {
        //todo: store in db
    }

    public function parseAllCategories()
    {
        $dom = new Dom();
        $html = $dom->loadFromUrl($this->url);

        foreach ($html->find('div.block.block_categories ul li a') as $categoryLink) {
            $categoryUrl = $categoryLink->href;
            $categoryName = $categoryLink->text;

            RepackCategory::updateOrInsert([
                'name' => $categoryName,
                'url' => $categoryUrl,
            ]);
        }

    }

    /**
     * @param string $categoryUrl
     * @return void
     * @throws \PHPHtmlParser\Exceptions\ChildNotFoundException
     * @throws \PHPHtmlParser\Exceptions\CircularException
     * @throws \PHPHtmlParser\Exceptions\CurlException
     * @throws \PHPHtmlParser\Exceptions\NotLoadedException
     * @throws \PHPHtmlParser\Exceptions\StrictException
     */
    public function parseCategory(RepackCategory $category): void
    {
        $dom = new Dom();
        $html = $dom->loadFromUrl($category->url);

        foreach ($html->find('section.main__content div.entry') as $game) {
            $gameUrl = $game->find('div.entry__title.h2 a')->href;
            $gameTitle = $game->find('div.entry__title.h2 a')->text;
            $gameImg = $game->find('div.entry_content img')->src;
            $gameDescription = trim($game->find('div.entry__content-description')->text);
            $gameUpdateDate = $game->find('div.entry__info-categories')->text; //todo: change Today to date

            Repack::updateOrInsert([
                'title' => $gameTitle,
                'repack_url' => $gameUrl,
                'image' => $gameImg,
                'description' => $gameDescription,
                'update_date' => $gameUpdateDate,
                'category_id' => $category->id
            ]);
        }
    }

    public function parseGame(Repack $game)
    {
        $dom = new Dom();
        $html = $dom->loadFromUrl($game->repack_url);

        $gameTitle = $html->find('h1.inner-entry__title')->text;
        $gameSize = $html->find('span.entry__info-size')->text;
        $gameDetails = $html->find('div.inner-entry__details')->innerHTML;
        $gameSystemReqs = $html->find('ul.inner-entry__sysreq-list');

        $requirements = '';
        foreach ($gameSystemReqs->find('li') as $gameSystemReq) {
            $requirements .= $gameSystemReq->text;
        }

        $descriptionSpan = '';
        $gameDescriptionSpans = $html->find('div#msg');
        foreach ($gameDescriptionSpans->find('span') as $gameDescriptionSpan) {
            if (!strlen($gameDescriptionSpan->text)) continue;

            $descriptionSpan .= trim($gameDescriptionSpan->text) . "\n";
        }

        preg_match('/Год выпуска: <\/strong> (.*?)<br \/>/', $gameDetails, $releaseDate);

        $genres = [];
        $html->find('div.inner-entry__details a')->each(function ($genre = '') use (&$genres) {
            if (trim($genre->text) !== '')
                $genres[] = $genre->text;
        });
        $genre = implode(', ', $genres);

        $gameTorrentUrl = $html->find('div#download a');
        $gameTorrentUrl = !sizeof($gameTorrentUrl) ? '' : $gameTorrentUrl->href;

        $postedAt = $html->find('span.entry__date')->text;

        $repack = $this->updateRepackInformation([
            'id' => $game->id,
            'title' => $gameTitle,
            'repack_url' => $game->repack_url,
            'description' => $descriptionSpan,
            'size' => $gameSize,
            'file' => $gameTorrentUrl,
            'genre' => $genre,
            'release_date' => $releaseDate[1],
            'posted_at' => $postedAt,
            'parsed' => false
        ]);

        TelegramService::sendCompletionReportToTelegram($repack);
    }

    private function updateRepackInformation(array $repackArray)
    {
        $repack = Repack::find($repackArray['id']);
        $repack->update($repackArray);

        return $repack;
    }
}