<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PrintJob;
use App\Models\FilamentColor;
use App\Models\Color;
use App\Models\Filament;

use App\Http\Requests;
use Charts;

class ChartsController extends Controller
{
    public function index()
    {
        // $chart = Charts::multi('bar', 'material')
        //     // Setup the chart settings
        //     ->title("My Cool Chart")
        //     // A dimension of 0 means it will take 100% of the space
        //     ->dimensions(0, 400) // Width x Height
        //     // This defines a preset of colors already done:)
        //     ->template("material")
        //     // You could always set them manually
        //     // ->colors(['#2196F3', '#F44336', '#FFC107'])
        //     // Setup the diferent datasets (this is a multi chart)
        //     ->dataset('Element 1', [5,20,100])
        //     ->dataset('Element 2', [15,30,80])
        //     ->dataset('Element 3', [25,10,40])
        //     // Setup what the values mean
        //     ->labels(['One', 'Two', 'Three']);

        // $chart3 = Charts::database(FilamentColor::whereDepartment(auth()->user()->department)->get(), 'bar', 'google')
            
            // ->title('Filaments')

            // ->groupBy('filament')
            // ->labels(Filament::all()->pluck('name'));

    //         $chart3 = Charts::multi('bar', 'highcharts')
    //         ->title('Filament Colors')
    // ->colors(['#ff0000', '#00ff00', '#0000ff'])
    // ->labels(Color::all()->pluck('name'))
    // ->dataset('PolyLite PLA', FilamentColor::where('department',auth()->user()->department)->where('filament', 1)->pluck('quantity'))
    // ->dataset('nGEN', FilamentColor::where('department',auth()->user()->department)->where('filament', 2)->pluck('quantity'))
    // ->dataset('NinjaFlex', FilamentColor::where('department',auth()->user()->department)->where('filament', 3)->pluck('quantity'));


           $chart2 = Charts::database(PrintJob::where('status', 4)->where('department', auth()->user()->department)->get(), 'line', 'highcharts')
            ->title('Prints Per Month')
            ->groupByMonth()
            ->labels(['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'])
            ->elementLabel("Prints")
            ->dimensions(0,500);

            $chart = Charts::database(PrintJob::whereDepartment(auth()->user()->department)->get(), 'pie', 'highcharts')
            ->title('Printjobs by status')
            ->groupBy('status')
            ->colors(['#2196F3', '#FFC107', '#F44336', '#32CD32'])
            ->labels(['Denied','Printing Complete','Pending Print', 'Pending Approval','Printing',]);

        

        /*
        Function that adds up all the weight of the used up filaments per month
        */
        function calculateFilamentGramsPerMonth($color, $filament) {
            
            $myArray = array();
            for ($i = 1; $i <= 12; $i++) {
                $monthNumString = str_pad($i, 2, "0", STR_PAD_LEFT);
                $myArray[$i] = PrintJob::where('color', $color)->where('department', auth()->user()->department)->where('filament', $filament)->whereMonth('created_at',date($monthNumString))->get()->sum->weight;
            }
            return $myArray;
        }

            $filamentChart1 = Charts::multi('bar', 'highcharts')
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


    
            

            

    $chart3 = Charts::multi('bar', 'highcharts')
            ->title('Filament Colors')
    ->colors(Color::all()->pluck('hex_code')->all())
    ->labels(Filament::all()->pluck('name'));

    foreach (Color::all() as $color) {
        $chart3 = $chart3->dataset($color->name, FilamentColor::where('department',auth()->user()->department)->where('color', $color->id)->pluck('quantity'));
    } 
    

        return view('admin.charts.index', ['chart3' => $chart3, 'chart' => $chart, 'chart2' => $chart2, 'filamentChart1' => $filamentChart1, 'filamentChart2' => $filamentChart2, 'filamentChart3' => $filamentChart3]);
    }
}