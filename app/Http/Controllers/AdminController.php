<?php

namespace App\Http\Controllers;

use App\Models\PrintJob;
use App\Models\Status;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the Admin Dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $statuses = Status::all();
        
        foreach($statuses as $status){
            $printJobs[$status->id] = PrintJob::with('currentStatus')->where('status', $status->id)->paginate(20);
        }
        return view('admin.index', compact('printJobs', 'statuses'));
    }


    public function update(Request $request, $id)
    {
        //$this->authorize();
        $printJob = PrintJob::find($id);
        $printJob->status = 3;
        $printJob->save();

        return redirect()->back();
        
    }
}
