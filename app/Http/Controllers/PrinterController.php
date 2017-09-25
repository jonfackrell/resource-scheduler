<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Printer;
use App\Models\Department;
use Auth;

class PrinterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view-printers');

        $printers = Printer::whereDepartment(auth()->guard('web')->user()->department)->get();
        $departments = Department::all()->pluck('name','id')->all();
        return view('admin.printer.index', compact('printers','departments'));
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
        $this->authorize('create-printers');
        $printer = new printer();
        $printer->fill($request->all());
        $printer->department = auth()->guard('web')->user()->department;
        $printer->save();

        return redirect()->route('printer.index');
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
        $this->authorize('edit-printers');

        $printer = Printer::find($id);

        return view('admin.printer.edit', compact('printer'));
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
        $this->authorize('edit-printers');

        $printer = Printer::find($id);
        $printer->fill($request->all());
        $printer->save();

        return redirect()->route('printer.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        $this->authorize('edit-printers');

        $order = json_decode($request->get('order'))[0];
        foreach($order as $key => $row){
            $printer = Printer::find($row->id);
            $printer->order_column = $key;
            $printer->save();
        }
        return response()->json(['status' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-printers');

        $printer = Printer::findorFail($id);
        $printer->delete();

        return redirect()->back();
    }
}
