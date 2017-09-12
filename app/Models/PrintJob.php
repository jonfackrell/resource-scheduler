<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrintJob extends Model
{

    public function getOptionsAttribute()
    {
        return json_decode( $this->attributes['options'] );
    }

    public function setOptionsAttribute( $val )
    {
        $this->attributes['options'] = json_encode( $val );
    }

    public function getCostAttribute()
    {
        return $this->attributes['cost'] / 100;
    }

    /**
     * Get the status.
     */
    public function currentStatus()
    {
        return $this->belongsTo(Status::class, 'status', 'id');
    }


    /**
     * Get the patron.
     */
    public function owner()
    {
        return $this->belongsTo(Patron::class, 'patron', 'id');
    }

    /**
     * Get the department.
     */
    public function departmentOwner()
    {
        return $this->belongsTo(Department::class, 'department', 'id');
    }


    protected $fillable = [
        'patron', 'color', 'filament', 'department', 'original_filename', 'filename'
    ];

    /**
     * Calculate Cost to Charge.
     */
    public function calculateCost()
    {
        return $this->attributes['cost'];
    }

    public function getFilament()
    {
        return $this->belongsTo(Filament::class, 'filament', 'id');
    }


}
