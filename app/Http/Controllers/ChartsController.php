<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PrintJob;
use App\Models\FilamentColor;
use App\Models\Color;
use App\Models\Filament;
use App\Models\Status;

use App\Http\Requests;
use Charts;

class ChartsController extends Controller
{
    public function index()
    {
        


            $printJobLineGraph = Charts::database(PrintJob::where('status', 4)->where('department', auth()->user()->department)->get(), 'line', 'highcharts')
            ->title('Prints Per Month')
            ->groupByMonth()
            ->labels(['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'])
            ->elementLabel("Prints")
            ->dimensions(0,500);

            $statusPieChart = Charts::database(PrintJob::whereDepartment(auth()->user()->department)->get()->sortBy->status, 'pie', 'highcharts')
            ->title('Printjobs by status')
            ->groupBy('status')
            ->colors(['#2196F3', '#FFC107', '#F44336', '#32CD32', '#24ddf0'])
            ->labels(Status::all()->pluck('name'));

        

        /*
        Function that adds up all the weight of the used up filaments per month
        */
        function calculateFilamentGramsPerMonth($color, $filament) {
            
            $myArray = array();
            for ($i = 1; $i <= 12; $i++) {
                $monthNumString = str_pad($i, 2, "0", STR_PAD_LEFT);
                $myArray[$i] = PrintJob::where('color', $color)->where('department', auth()->user()->department)->where('filament', $filament)->where('status', 4)->whereYear('created_at', date("Y"))->whereMonth('created_at',date($monthNumString))->get()->sum->weight;
            }
            return $myArray;
        }

            $filamentChart1 = Charts::multi('line', 'highcharts')
                        ->title('PolyLite PLA')
                ->colors(Color::all()->pluck('hex_code')->all())
                ->labels(['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']);

            foreach (Color::all() as $color) {
                    $filamentChart1 = $filamentChart1->dataset($color->name, calculateFilamentGramsPerMonth($color->id,1));
                } 

                $filamentChart2 = Charts::multi('line', 'highcharts')
                        ->title('nGEN')
                ->colors(Color::all()->pluck('hex_code')->all())
                ->labels(['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']);

            foreach (Color::all() as $color) {
                    $filamentChart2 = $filamentChart2->dataset($color->name, calculateFilamentGramsPerMonth($color->id,2));
                } 

                $filamentChart3 = Charts::multi('line', 'highcharts')
                        ->title('NinjaFlex')
                ->colors(Color::all()->pluck('hex_code')->all())
                ->labels(['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']);

            foreach (Color::all() as $color) {
                    $filamentChart3 = $filamentChart3->dataset($color->name, calculateFilamentGramsPerMonth($color->id,3));
                } 


    
            

            

    $filamentQuantityByColor = Charts::multi('bar', 'highcharts')
            ->title('Filament Colors')
    ->colors(Color::all()->pluck('hex_code')->all())
    ->labels(Filament::all()->pluck('name'));

    foreach (Color::all() as $color) {
        $filamentQuantityByColor = $filamentQuantityByColor->dataset($color->name, FilamentColor::where('department',auth()->user()->department)->where('color', $color->id)->pluck('quantity'));
    } 
    

        return view('admin.charts.index', ['chart3' => $filamentQuantityByColor, 'chart2' => $printJobLineGraph, 'chart' => $statusPieChart, 'filamentChart1' => $filamentChart1, 'filamentChart2' => $filamentChart2, 'filamentChart3' => $filamentChart3]);
    }
}