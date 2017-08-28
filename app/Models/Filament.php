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


        return $this->belongsToMany('App\Models\Color', 'filaments_colors', 'filament', 'color');
    }

}
