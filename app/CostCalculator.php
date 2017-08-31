<?php
/**
 * Created by PhpStorm.
 * User: fackrelj
 * Date: 8/25/2017
 * Time: 9:33 AM
 */

namespace App;


use App\Models\Filament;
use App\Models\Printer;
use App\Models\PrintJob;

class CostCalculator
{

    function __construct($params)
    {
        $this->params = $params;
    }

    function bestPrinterPrice($filament)
    {
        $printers = Printer::whereHas('filaments', function($query) use ($filament){
            $query->where('filament', $filament->id);
        })->get();
        $printers->each(function($printer, $key) use ($filament){
            $printer->patronCostToPrint($this->params, $filament);
        });
        $printers = $printers->sortBy('costToPrint');
        return $printers;
    }

}