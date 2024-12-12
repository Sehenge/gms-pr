<?php

namespace App\Services;

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

        foreach($html->find('div.block.block_categories ul li a') as $categoryLink) {
            $categoryUrl = $categoryLink->href;
            $categoryName = $categoryLink->text;

//            dump($categoryName);
        }

//        dd($this->url);
    }

    public function parseCategory(string $category)
    {
        $dom = new Dom();
        $html = $dom->loadFromUrl($category);

        foreach($html->find('section.main__content div.entry') as $game) {

//            dd($game->find('a')->text);
            $gameUrl = $game->find('div.entry__title.h2 a')->href;
            $gameTitle = $game->find('div.entry__title.h2 a')->text;
            $gameImg = $game->find('div.entry_content img')->src;
            $gameDescription = trim($game->find('div.entry__content-description')->text);
            $gameUpdateDate = $game->find('div.entry__info-categories')->text; //todo: change Today to date

            dd($gameUpdateDate);
            dd($gameTitle);
        }

        dd($this->url);
    }
}