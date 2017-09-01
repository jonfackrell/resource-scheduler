<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Printer extends Model implements Sortable
{

    use SortableTrait;

    protected $appends = ['costToPrint', 'timeToPrint'];

    protected $fillable = ['name', 'description', 'department', 'flat_fee', 'per_hour', 'overtime_fee', 'overtime_start'];

    /**
     * The department that owns the printer.
     */
    public function departmentOwner()
    {
        return $this->belongsTo('App\Models\Department', 'department');
    }

    /**
     * The filaments that can be printed with printer.
     */
    public function filaments()
    {
        return $this->belongsToMany('App\Models\Filament', 'printers_filaments', 'printer', 'filament');
    }

    /**
     * The filaments that can be printed with printer.
     */
    public function colors($department)
    {
        //return $this->hasManyThrough('App\Models\Color', 'App\Models\Filament', 'department', 'filament', 'id');
        //return $this->filaments->colors;
        //return $this->belongsToMany('App\Models\Color', 'filaments_colors', 'printer', 'colors');
    }

    public function patronCostToPrint($params, $filament)
    {
        // Get the options from the printer's filament
        $options = $filament->options($this->getKey());
        // Add flat printing fee
        $cost = ( $this->attributes['flat_fee'] );
        // Calculate cost per hour to print
        $cost += ( ( $params['time'] / 60 ) * $this->attributes['per_hour'] );
        // Calculate cost of material using both the additional cost per gram and cost multiplier
        $cost += ( $params['weight'] * ( ( $options->cost_per_gram ) + ( $options->add_cost_per_gram ) ) * $options->multiplier  );
        // Add additional fees for printing over a certain amount of time
        if( $this->attributes['overtime_start'] > 0 ){
            $cost += ( $this->attributes['overtime_fee'] * ( (int)$params['time']/$this->attributes['overtime_start'] ) );
        }
        // Add tax tax to total cost
        $this->attributes['costToPrint'] = ( $cost * $this->departmentOwner->tax_rate );
        $this->attributes['timeToPrint'] = $this->timeToPrint();
    }


    public function timeToPrint()
    {
        return 24;
    }


}
