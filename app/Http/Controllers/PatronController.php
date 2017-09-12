<?php

namespace App\Http\Controllers;

use App\CostCalculator;
use App\Models\Filament;
use App\Models\Printer;
use App\Models\PrintJob;
use App\Models\Setting;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Models\Patron;
use App\Models\Department;

class PatronController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::all()->pluck('name', 'id')->all();
        return view('patron.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Display a options form.
     *
     * @return \Illuminate\Http\Response
     */
    public function options()
    {
        $statuses = Status::where('accept_payment', 1)->pluck('id')->all();
        $public = Setting::where('group', 'PUBLIC')->get();
        return view('patron.model-options', compact('public'));

    }

    /**
     * Display a listing of printers.
     *
     * @return \Illuminate\Http\Response
     */
    public function choosePrinter(Request $request)
    {
        $public = Setting::where('group', 'PUBLIC')->get();
        $filaments = Filament::all();
        if($request->has('time')){
            $time = $request->get('time');
        }else if($request->has('hours') && $request->has('minutes')){
            $time = $request->get('hours') * 60 + $request->get('minutes');
        }else{
            return redirect()->action('options');
        }
        if($request->has('filament')){
            $filament = $filaments->where('id', $request->get('filament'))->first();
        }else{
            $filament = $filaments->sortBy('order_column')->first();
        }
        session([
            'weight' => $request->get('weight'),
            'time' => $time,
            'filament' => $filament->id
        ]);
        $calulator = new CostCalculator(['weight' => session('weight'), 'time' => session('time')]);
        $printers = $calulator->bestPrinterPrice($filament);
        return view('patron.choose-printer', compact('printers', 'filaments', 'filament', 'public'))->with('', '');
    }

    /**
     * Display upload form.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        session([
            'printer' => $request->get('printer'),
            'color' => $request->get('color')
        ]);
        $public = Setting::where('group', 'PUBLIC')->get();
        $color = Color::findOrFail(session('color'));
        $printer = Printer::findOrFail(session('printer'));
        $department = Department::findOrFail($printer->departmentOwner->id);
        $filament = Filament::findOrFail(session('filament'));
        $printer->patronCostToPrint(['weight' => session('weight'), 'time' => session('time')], $filament);
        return view('patron.submit', compact('printer', 'filament', 'color', 'public', 'department'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request)
    {

        $printer = Printer::findOrFail(session('printer', $request->get('printer')));
        $filament = Filament::findOrFail(session('filament', $request->get('filament')));
        $printer->patronCostToPrint(['weight' => session('weight', $request->get('weight')), 'time' => session('time', $request->get('time'))], $filament);

        $printjob = new PrintJob;
        $printjob->fill($request->all());
        $printjob->patron = auth()->guard('patrons')->user()->id;
        $printjob->cost = $printer->costToPrint;


        if($request->hasFile('filename')) {

            $filename = $request->filename->store('public/upload');
            // return 'yes';
            $printjob->filename = $filename;
            $printjob->original_filename = $request->filename->getClientOriginalName();

        }

        $department = Department::findOrFail($printer->departmentOwner->id);
        $printjob->status = $department->initial_status;

        $printjob->save();

        return redirect()->route('history');

    }

    /**
     * Display the history of uploads
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function history()
    {
        $public = Setting::where('group', 'PUBLIC')->get();
        $printJobs = PrintJob::wherePatron(auth()->guard('patrons')->user()->id)->orderBy('updated_at', 'DESC')->paginate(20);
        return view('patron.history', compact('printJobs', 'public'));
    }
}
