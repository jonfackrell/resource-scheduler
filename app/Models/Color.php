<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'hex_code'];

public function filaments()
    {


        return $this->belongsToMany('App\Models\Filament', 'filaments_colors', 'color', 'filament');
    }


}
