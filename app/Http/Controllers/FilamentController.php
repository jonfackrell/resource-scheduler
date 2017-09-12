<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\FilamentColor;
use App\Models\Patron;
use App\Models\Printer;
use App\Models\PrinterFilament;
use Illuminate\Http\Request;
use App\Models\Filament;


class FilamentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view-filaments');

        $filaments = Filament::orderBy('order_column')->get();
        $printers = Printer::whereDepartment(auth()->guard('web')->user()->department)->get();

        return view('admin.filament.index', compact('filaments', 'printers'));
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
        $this->authorize('create-filaments');

        $filament = new Filament();
        $filament->fill($request->all());
        $filament->save();

        return redirect()->route('filament.index');
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
        $this->authorize('edit-filaments');

        $filament = Filament::find($id);

        return view('admin.filament.edit', compact('filament'));
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
        $this->authorize('edit-filaments');

        $filament = Filament::find($id);
        $filament->fill($request->all());
        $filament->save();

        return redirect()->route('filament.index');
        
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
        $this->authorize('edit-filaments');

        $order = json_decode($request->get('order'))[0];
        foreach($order as $key => $row){
            $filament = Filament::find($row->id);
            $filament->order_column = $key;
            $filament->save();
        }
        return response()->json(['status' => true]);
    }

    /**
     * Add or remove printer that can print with the given filament.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function togglePrinter(Request $request, $id)
    {
        $this->authorize('edit-printers');
        $filament = Filament::findOrFail($id);
        if($request->get('action') == "true"){
            $filament->printers()->attach($request->get('printerid'));
        }else{
            $filament->printers()->detach($request->get('printerid'));
        }

        return response()->json(['status' => true]);
    }

    /**
     * Manage filament colors.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showColorManager(Request $request, $filamentid, $printerid)
    {
        $this->authorize('edit-printers');
        $printer = Printer::findOrFail($printerid);
        $filament = Filament::findOrFail($filamentid);
        $colors = Color::select('*', 'filaments_colors.id AS colorid')
                    ->join('filaments_colors', 'colors.id', '=', 'filaments_colors.color')
                    ->where('filaments_colors.filament', $filament->id)
                    ->where('filaments_colors.department', auth()->guard('web')->user()->department)
                    ->get();
        return view('admin.filament.color-manager', compact('printer', 'filament', 'colors'));
    }

    /**
     * Manage filament colors.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateColorManager(Request $request, $filamentid, $printerid)
    {
        $this->authorize('edit-printers');

        $inputs = $request->all();

        foreach($inputs as $key => $value){
            if(0 === strpos($key, 'quantity_')){
                $color = explode('_', $key)[1];
                $filament_color = FilamentColor::findOrFail(intval($color));
                $filament_color->quantity = $value;
                $filament_color->save();
            }
        }

        $filament = Filament::findOrFail($filamentid);

        return redirect()->back()->with('success', "All color quatities have been updated for <b>$filament->name</b>");
    }

    /**
     * Manage filament pricing.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showPricingManager(Request $request, $filamentid, $printerid)
    {
        $this->authorize('edit-filaments');

        $filament = Filament::findOrFail($filamentid);
        $printer = Printer::findOrFail($printerid);
        $pricingOptions = $filament->options($printerid);

        return view('admin.filament.pricing-manager', compact('filament', 'printer', 'pricingOptions'));
    }

    /**
     * Manage filament pricing.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePricingManager(Request $request, $filamentid, $printerid)
    {
        $this->authorize('edit-printers');

        $printerFilament = PrinterFilament::findOrFail($request->get('pricing_options_id'));
        $printerFilament->cost_per_gram = $request->get('cost_per_gram');
        $printerFilament->add_cost_per_gram = $request->get('add_cost_per_gram');
        $printerFilament->multiplier = $request->get('multiplier');
        $printerFilament->save();

        return redirect()->route('filament.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-filaments');

        $filament = Filament::findorFail($id);
        $filament->delete();

        return redirect()->back();
    }
}
