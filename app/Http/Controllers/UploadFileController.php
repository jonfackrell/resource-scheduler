<?php

namespace App\Http\Controllers;

use App\CostCalculator;
use App\Models\Printer;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\PrintJob;
use App\Models\Department;
use App\Models\Filament;
use App\Models\Patron;
use App\Models\Color;

class UploadFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $printjobs = PrintJob::all();
        $filaments = Filament::all()->pluck('name', 'id')->all();
        $departments = Department::all()->pluck('name','id')->all();

        $patron = Patron::find(request()->get('id'));

        

        // $desired_object;

        // foreach ($patrons as $patron) {
        //     if ($patron->remember_token == 'HUe6sr39L8') {
        //         $desired_object = $patron;
        //         break;
        //     }
        // }

        // $patrons = $desired_object;


        // $patrons = Patron::get()->where('remember_token', 'HUe6sr39L8');
        //$options = Printjob::all()->pluck('options')->all();


        return view('uploadfile.index', compact('printjobs', 'departments', 'filaments', 'patron'));

    }


    /**
     * Display a options form.
     *
     * @return \Illuminate\Http\Response
     */
    public function options()
    {

        $public = Setting::where('group', 'PUBLIC')->get();
        return view('uploadfile.model-options', compact('public'));

    }

    /**
     * Display a listing of printers.
     *
     * @return \Illuminate\Http\Response
     */
    public function printers(Request $request)
    {
        $public = Setting::where('group', 'PUBLIC')->get();
        $filaments = Filament::all();
        if($request->has('filament')){
            $filament = $filaments->where('id', $request->get('filament'))->first();
        }else{
            $filament = $filaments->sortBy('order_column')->first();
        }
        session([
            'weight' => $request->get('weight'),
            'time' => $request->get('time'),
            'filament' => $filament->id
        ]);
        $calulator = new CostCalculator(['weight' => session('weight'), 'time' => session('time')]);
        $printers = $calulator->bestPrinterPrice($filament);
        return view('uploadfile.choose-printer', compact('printers', 'filaments', 'filament', 'public'));
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
        $filament = Filament::findOrFail(session('filament'));
        $printer->patronCostToPrint(['weight' => session('weight'), 'time' => session('time')], $filament);
        return view('uploadfile.upload', compact('printer', 'filament', 'color', 'public'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $printjob = new PrintJob;
        $printjob->fill($request->all());
        $printjob->patron = auth()->user()->id;


        if($request->hasFile('filename')) {

            $filename = $request->filename->store('public/upload');

            // return 'yes';
            $printjob->filename = $filename;
            $printjob->original_filename = $request->filename->getClientOriginalName();

        }

        $printjob->save();

        return 'done';

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
        
        $printjob = PrintJob::find($id);
        $patron = Patron::find($printjob->patron);
        $filaments = Filament::all()->pluck('name', 'id')->all();

        $departments = Department::all()->pluck('name','id')->all();
        return view('uploadfile.edit', compact('printjob', 'departments','filaments', 'patron'));
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
        $printjob = PrintJob::find($id);
        $printjob->fill($request->all());

        if($request->hasFile('filename')) {

            //$filename = $request->filename->getClientOriginalName();

            $filename = $request->filename->store('public/upload');

            // return 'yes';
            $printjob->filename = $filename;
            $printjob->original_filename = $request->filename->getClientOriginalName();
        }

        //save the stuff.
        $printjob->save();

        // return redirect()->route('uploadfile.index');
        return "done";


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
}
