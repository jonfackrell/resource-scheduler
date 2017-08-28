<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{


    protected $appends = ['costToPrint', 'timeToPrint'];

    protected $fillable = ['name', 'description', 'department'];

    /**
     * The department that owns the printer.
     */
    public function departmentOwner()
    {
        return $this->belongsTo('App\Models\Department', 'department');
    }

    public function patronCostToPrint($params)
    {
        // Formula: (Weights in grams x 7.5 cents) + ($1.00 for every 12 hours after the first 12)
        $cost = ( $params['weight'] * .075 ) + ( 100 * ( (int)$params['time']/12 ) );
        $this->attributes['costToPrint'] = $cost;
        $this->attributes['timeToPrint'] = 24;
    }




}
