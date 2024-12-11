<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repack extends Model
{
    public string $requirements {
        get => strtolower($this->requirements);
        set(string $requirements) {
            $this->requirements = strtoupper($requirements);
        }
    }


    public function __construct(string $requirements)
    {
        $this->requirements = $requirements;
    }
}
