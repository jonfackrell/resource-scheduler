<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Filament extends Model implements Sortable
{
    use SortableTrait;

    //
    protected $fillable = ['name', 'description', 'quantity'];

    /**
     * The colors that are in stock for the filament.
     */
    public function colors($department = 0, $weight = 0)
    {
        if($department == 0){
            return $this->belongsToMany('App\Models\Color', 'filaments_colors', 'filament', 'color');
        }
        else{
            return $this->belongsToMany('App\Models\Color', 'filaments_colors', 'filament', 'color')->where('department', $department)->where('quantity', '>', $weight)->get();
        }
    }

    /**
     * The departments that own the filament.
     */
    public function departments()
    {
        return $this->belongsToMany('App\Models\Department', 'departments_filaments', 'filament', 'department');
    }

    /**
     * The printers that can print filament.
     */
    public function printers()
    {
        return $this->belongsToMany('App\Models\Printer', 'printers_filaments', 'filament', 'printer');
    }

    /**
     * The pricing options for the filament.
     */
    public function options($printerid)
    {
        return $this->hasOne('App\Models\PrinterFilament', 'filament', 'id')->where('printer', $printerid)->first();
    }

}
