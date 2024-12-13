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

//        dd($this->url);
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
    public function parseCategory(string $categoryUrl)
    {
        $dom = new Dom();
        $html = $dom->loadFromUrl($categoryUrl);

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
            ]);
        }
    }

    public function parseGame(string $gameUrl)
    {
        $dom = new Dom();
        $html = $dom->loadFromUrl($gameUrl);

        $gameTitle = $html->find('h1.inner-entry__title')->text;
        $gameSize = $html->find('span.entry__info-size')->text;
        $gameDetails = $html->find('div.inner-entry__details')->text;
        $gameSystemReqs = $html->find('ul.inner-entry__sysreq-list');

        foreach ($gameSystemReqs->find('li') as $gameSystemReq) {
//            dump ($gameSystemReq->text);
        }

        $gameDescriptionSpans = $html->find('div#msg');

        foreach ($gameDescriptionSpans->find('span') as $gameDescriptionSpan) {
            if (!strlen($gameDescriptionSpan->text)) continue;

            $descriptionSpan = trim($gameDescriptionSpan->text);
            dump($descriptionSpan);
        }

        $gameTorrentUrl = $html->find('div#download a')->href;

//        dd($gameDescription);
    }
}