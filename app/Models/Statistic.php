<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    public const int PRICE = 114146;
    public function startCount(): void
    {
        $statistic = Statistic::where('date', '>=', date('Y-m-d'))->first();

        if ($statistic) {
            $minutes = $statistic->wminutes;

            $statistic->wminutes = $minutes + 1;
            $statistic->totalsal = round($statistic->hoursal / 60) * $statistic->wminutes;
            $statistic->save();
        } else {
            $statistic = new Statistic();
            $statistic->wminutes = 1;
            $statistic->save();
        }

        dump('Counter works with ' . $statistic->wminutes . ' minutes!');
    }
}
