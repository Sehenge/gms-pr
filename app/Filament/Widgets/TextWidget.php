<?php

namespace App\Filament\Widgets;

use App\Models\Statistic;
use Filament\Widgets\Widget;
use Illuminate\Contracts\View\View;

class TextWidget extends Widget
{
    protected static string $view = 'filament.widgets.text-widget';

    public function render(): View
    {
        $hSal = Statistic::find(1)->pluck('hoursal')->first();
        $sumTotal = Statistic::query()->sum('totalsal');

        $hours = round(Statistic::PRICE / $hSal, 2);
        $remaining = Statistic::PRICE - $sumTotal;

        return view('filament.widgets.text-widget', ['remainingHours' => $hours, 'remainingSum' => $remaining]);
    }

}
