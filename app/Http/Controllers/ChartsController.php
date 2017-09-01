<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PrintJob;
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
            ->labels(['Printed','Printing','Pending Approval', 'Printjob Approved']);
            

        return view('admin.charts.index', ['chart' => $chart, 'chart2' => $chart2]);
    }
}