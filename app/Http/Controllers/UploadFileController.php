<?php

namespace App\Http\Controllers;

use App\CostCalculator;
use App\Models\Printer;
use App\Models\Setting;
use App\Models\Status;
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

        return view('uploadfile.index', compact('printjobs', 'departments', 'filaments', 'patron'));

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
        $this->authorize('edit-print-jobs');

        \Illuminate\Support\Facades\Validator::make($request->all(), [
            'hours' => 'numeric|max:120',
            'minutes' => 'numeric|max:59',
            'weight' => 'numeric|max:3000',
        ])->validate();

        $printjob = PrintJob::find($id);
        $printjob->fill($request->all());
        $time = $request->get('hours') * 60 + $request->get('minutes');
        $printjob->time = $time;
        $printjob->options = $request->get('options');

        if($request->has('pricing_options')) {
            if ($request->get('pricing_options') == 'cost') {
                $filament = Filament::findOrFail($printjob->filament);
                $options = $filament->options($printjob->printer);
                $printjob->cost = ($printjob->weight * $options->cost_per_gram);
            } else if ($request->get('pricing_options') == 'free') {
                $printjob->cost = 0;
            } else {
                $filament = Filament::findOrFail($printjob->filament);
                $printer = Printer::findOrFail($printjob->printer);
                $printer->patronCostToPrint(['weight' => $printjob->weight, 'time' => $printjob->time], $filament);
                $printjob->cost = $printer->costToPrint;
            }
        }

        //save the stuff.
        $printjob->save();

        if($request->hasFile('filename')) {

            $filename = $request->filename->store('public/upload/' . $printjob->created_at->year . '/' . $printjob->created_at->month);
            
            $printjob->filename = $filename;
            $printjob->original_filename = $request->filename->getClientOriginalName();
        }

        $printjob->save();

        return redirect()->route('admin', ["#$printjob->status"]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->authorize('delete-print-jobs');

        $filament = PrintJob::findorFail($id);
        $filament->delete();

        return redirect()->back();
    }

}
