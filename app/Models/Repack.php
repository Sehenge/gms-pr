<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Repack extends Model
{
    public $fillable = [
        'title',
        'url',
        'image',
        'repack_url',
        'description',
        'update_date'
    ];

    public string $requirements {
        get => strtolower($this->requirements);
        set(string $requirements) {
            $this->requirements = strtoupper($requirements);
        }
    }
}
