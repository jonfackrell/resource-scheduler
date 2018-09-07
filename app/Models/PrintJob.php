<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Events\Event;

class PrintJob extends Model
{

    protected $fillable = [
        'patron', 'color', 'filament', 'department', 'printer', 'original_filename', 'filename', 'completed', 'weight', 'time', 'options', 'purpose'
    ];

    public function getOptionsAttribute()
    {
        return json_decode( $this->attributes['options'] );
    }

    public function setOptionsAttribute( $val )
    {
        $this->attributes['options'] = json_encode( $val );
    }

    public function getNetCostAttribute()
    {
        $totalCost = $this->attributes['cost'] / 100;
        if($totalCost < 0){
            $totalCost = 0;
        }
        return $totalCost;
    }

    public function getTotalCostAttribute()
    {
        $totalCost = ($this->attributes['cost'] + $this->attributes['tax']) / 100;
        if($totalCost < 0){
            $totalCost = 0;
        }
        return $totalCost;
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
     * Get the messages.
     */
    public function messages()
    {
        return $this->hasMany(Messages::class, 'printjob', 'id');
    }

    /**
     * Get the files.
     */
    public function files()
    {
        return $this->hasMany(File::class)->orderBy('created_at', 'DESC');
    }

    /**
     * Get the printer.
     */
    public function selectedPrinter()
    {
        return $this->belongsTo(Printer::class, 'printer', 'id');
    }

    /**
     * Get the department.
     */
    public function departmentOwner()
    {
        return $this->belongsTo(Department::class, 'department', 'id');
    }


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

    public function getColor()
    {
        return $this->belongsTo(Color::class, 'color', 'id');
    }

    /*attempt at sending an email to patron incomplete
    public function setStatusAttribute($value)
    {
        // $patron = Patron::find($this->patron);
        // switch($value){
        //     case 1:
        //         break;
        //     case 2:
        //         $patron->notify(new \App\Notifications\SendDifferentFileNotification($this->attributes['id']));
        //         break;      
        // }


         
         $printJob = PrintJob::findOrFail($this->id);
        
        event(new Event($printJob, $value));

        $this->attributes['status'] = $value;


        
    }
    */
    public function sendDifferentFileNotification($token)
    {
        $this->notify(new sendDifferentFileNotification($token));
    }


}
