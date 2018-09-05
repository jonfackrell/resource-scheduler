<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Printer extends Model implements Sortable
{

    use SortableTrait;

    protected $appends = ['costToPrint', 'timeToPrint'];

    protected $fillable = ['name', 'description', 'department', 'image', 'flat_fee', 'per_hour', 'overtime_fee', 'overtime_start'];

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
        return $this->belongsToMany('App\Models\Filament', 'printers_filaments', 'printer', 'filament')->withPivot('cost_per_gram', 'add_cost_per_gram', 'multiplier');
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

    public function patronCostToPrint($params, $filament, $code = null)
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
        if(!is_null($code)){
            $coupon = Coupon::where('code', $code)->whereNull('redeemed_at')->first();
            if(is_null($coupon)){
                $coupon = new Coupon();
                $coupon->value = 0;
            }
        }else{
            $coupon = new Coupon();
            $coupon->value = 0;
        }

        $this->attributes['coupon'] = $coupon->value;
        $this->attributes['netCostToPrint'] = ( $cost );
        $this->attributes['tax'] = ( ($this->attributes['netCostToPrint'] - $coupon->value) * ( $this->departmentOwner->tax_rate - 1 ) );
        // Add tax tax to total cost
        if(($this->attributes['netCostToPrint'] - $coupon->value) > 0){
            $this->attributes['costToPrint'] = ( ($this->attributes['netCostToPrint'] - $coupon->value) * $this->departmentOwner->tax_rate );
        }else{
            $this->attributes['costToPrint'] = 0;
        }
        $this->attributes['timeToPrint'] = $this->timeToPrint();

    }


    public function timeToPrint()
    {
        $date = \Carbon\Carbon::now();

        $statuses = Status::whereInQueue(1)
            ->whereDepartment($this->attributes['department'])
            ->pluck('id')
            ->all();

        $time = PrintJob::select(\DB::raw('SUM(time) as total'))
                    ->whereIn('status', $statuses)->first()->total + 30;

        return $date->addMinutes($time);
    }


}
