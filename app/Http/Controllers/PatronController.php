<?php

namespace App\Http\Controllers;

use App\CostCalculator;
use App\Events\PrintJobCreated;
use App\Models\Color;
use App\Models\Filament;
use App\Models\Printer;
use App\Models\PrintJob;
use App\Models\Setting;
use App\Models\Status;
use App\Notifications\GenericNotification;
use App\Notifications\QuestionNotification;
use Illuminate\Http\Request;
use App\Models\Patron;
use App\Models\Department;
use Illuminate\Validation\Validator;

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $printJob = PrintJob::findOrFail($id);

        if(auth()->guard('patrons')->user()->can('view', $printJob)){
            $public = Setting::where('group', 'PUBLIC')->get();
            $filament = $printJob->getFilament;
            $printer = $printJob->selectedPrinter;
            $printer->patronCostToPrint(['weight' => $printJob->weight, 'time' => $printJob->time], $filament);
            return view('patron.show-print-job', compact('printJob', 'printer', 'filament', 'public'));
        }else{
            abort(401, 'Unauthorized!!');
        }
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

        \Illuminate\Support\Facades\Validator::make($request->all(), [
            'hours' => 'numeric|max:120',
            'minutes' => 'numeric|max:59',
            'weight' => 'numeric|max:3000',
        ])->validate();

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

        \Illuminate\Support\Facades\Validator::make($request->all(), [
            'filename' => 'file'
        ])->validate();

        $printer = Printer::findOrFail(session('printer', $request->get('printer')));
        $filament = Filament::findOrFail(session('filament', $request->get('filament')));
        $printer->patronCostToPrint(['weight' => session('weight', $request->get('weight')), 'time' => session('time', $request->get('time'))], $filament);

        $printjob = new PrintJob;
        $printjob->fill($request->all());
        $printjob->department = $printer->department;
        $printjob->patron = auth()->guard('patrons')->user()->id;
        $printjob->cost = $printer->costToPrint;
        $printjob->cost_per_gram = $filament->options($printer->id)->cost_per_gram;
        $printjob->options = $request->get('options');

        $department = Department::findOrFail($printer->departmentOwner->id);
        $printjob->status = $department->initial_status;

        $printjob->save();

        if($request->hasFile('filename')) {
            $filename = $request->file('filename')->store('public/upload/' . $printjob->created_at->year . '/' . $printjob->created_at->month);
            $printjob->filename = $filename;
            $printjob->original_filename = $request->filename->getClientOriginalName();
        }

        $printjob->save();

        event(new PrintJobCreated($printjob));

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


    /**
     * Download file
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($filename)
    {
        $printJob = PrintJob::whereFilename($filename)->first();
        return response()->download(storage_path('app') . '/' . $filename, $printJob->original_filename);
    }

}
