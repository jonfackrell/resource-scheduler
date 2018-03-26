<?php

namespace App\Http\Controllers;

use App\Models\Printer;
use Illuminate\Http\Request;

class DashboardApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function wait(Request $request, $id)
    {
        $status = [];

        if(!is_null($id)){
            $printers = Printer::where('id', $id)->get();
        }else{
            $printers = Printer::all();
        }

        foreach($printers as $printer){
            $status[] = [
                'id' => $printer->id,
                'wait' => $printer->timeToPrint()->diffForHumans()
            ];
        }

        return response()->json($status)->withCallback($request->get('callback'));
    }

}
