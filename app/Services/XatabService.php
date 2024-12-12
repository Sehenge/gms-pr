<?php

namespace App\Services;

class XatabService
{
    private string $url;

    public function __construct()
    {
        $this->url = config('repacks.source.xatab');
    }

    public function parseCategories()
    {
        dd($this->url);
    }
}