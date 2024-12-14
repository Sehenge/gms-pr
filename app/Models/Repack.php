<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Repack extends Model
{
    public $fillable = [
        'title',
        'url',
        'image',
        'repack_url',
        'description',
        'category_id',
        'update_date'
    ];

    public string $requirements {
        get => strtolower($this->requirements);
        set(string $requirements) {
            $this->requirements = strtoupper($requirements);
        }
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(RepackCategory::class, 'category_id', 'id');
    }
}
