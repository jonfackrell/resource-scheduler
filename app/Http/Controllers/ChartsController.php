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

        $statuses = Status::whereDepartment(auth()->guard('web')->user()->department)->get();

        $printJobsByMonth = Charts::database(
                                    PrintJob::whereIn('status', $statuses->where('completed', 1)->pluck('id'))
                                        ->where('department', auth()->guard('web')->user()->department)->get()
                                    , 'line', 'highcharts')
                                ->title('Prints by Month')
                                ->lastByMonth(12, true)

                                ->elementLabel("Printed 3D Objects")
                                ->dimensions(0,500);


        $currentStatuses = Charts::database(
                                    PrintJob::whereDepartment(auth()->guard('web')->user()->department)
                                        ->whereIn('status', $statuses->where('completed', 0)
                                        ->pluck('id'))->get()
                                    , 'pie', 'highcharts')
                                ->title('Current Print Status')
                                ->groupBy('status','currentStatus.name');


        $colors = Color::all();
        $filaments = Filament::all();
        $filamentQuantityByColor = Charts::multi('bar', 'highcharts')
                                        ->title('Filament Inventory')
                                        ->colors($colors->pluck('hex_code')->transform(function($item, $key){ return '#'.$item; })->all())
                                        ->labels($filaments->pluck('name'))
                                        ->elementLabel("Total (grams)");

        foreach ($colors as $color) {
            $filamentQuantityByColor = $filamentQuantityByColor->dataset($color->name,
                FilamentColor::where('department', auth()->guard('web')->user()->department)
                    ->where('color', $color->id)
                    ->pluck('quantity')
            );
        }

        $filamentUsage = [];

        foreach($filaments as $key => $filament){

            $filamentUsage[$filament->id] = Charts::multiDatabase('line', 'highcharts')
                                                ->title($filament->name)
                                                ->colors($colors->pluck('hex_code')->transform(function($item, $key){ return '#'.$item; })->all());

            foreach ($colors as $color) {

                $printJobs = PrintJob::select('created_at', \DB::raw('SUM(weight) as aggregate'))
                                ->whereColor($color->id)
                                ->whereDepartment(auth()->guard('web')->user()->department)
                                ->whereFilament($filament->id)
                                ->groupBy('created_at')
                                ->get();

                $filamentUsage[$filament->id]->dataset($color->name, $printJobs)->preaggregated(true);
                $filamentUsage[$filament->id] = $filamentUsage[$filament->id]->lastByMonth(12, true);
            }

        }

        /*
        Function that adds up all the weight of the used up filaments per month
        */
        /*
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

        */
    

        return view('admin.charts.index', compact('printJobsByMonth', 'currentStatuses', 'filamentQuantityByColor', 'filamentUsage'));
    }
}