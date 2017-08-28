<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filament extends Model
{
    //
    protected $fillable = ['name', 'description', 'quantity'];

    /**
     * The colors that are in stock for the filament.
     */
    public function colors()
    {
        return $this->belongsToMany(Color::class, 'filaments_colors', 'color', 'filament');
    }

}
