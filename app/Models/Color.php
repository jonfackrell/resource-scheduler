<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Color extends Model implements Sortable
{
    use SortableTrait;

    public $timestamps = false;
    protected $fillable = ['name', 'hex_code', 'order_column'];

    public function filaments()
    {


        return $this->belongsToMany('App\Models\Filament', 'filaments_colors', 'color', 'filament');
    }


}
