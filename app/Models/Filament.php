<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filament extends Model
{
    /**
     * The colors that are in stock for the filament.
     */
    public function colors()
    {
        return $this->belongsToMany('App\Models\Color', 'filaments_colors', 'color', 'filament');
    }
}
