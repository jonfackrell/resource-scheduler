<?php
/**
 * Created by PhpStorm.
 * User: fackrelj
 * Date: 8/25/2017
 * Time: 9:33 AM
 */

namespace App;


use App\Models\Printer;
use App\Models\PrintJob;

class CostCalculator
{

    function __construct($params)
    {
        $this->params = $params;
    }

    function bestPrinterPrice()
    {
        $printers = Printer::all();
        $printers->each(function($printer, $key){
            $printer->patronCostToPrint($this->params);
        });
        $printers = $printers->sortBy('costToPrint');
        return $printers;
    }

}