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
        $statuses = Status::whereDashboardDisplay(1)
                        ->whereDepartment(auth()->guard('web')->user()->department)
                        ->orderBy('order_column', 'ASC')
                        ->get();
        $printJobs = [];
        foreach($statuses as $status){
            $printJobs[$status->id] = PrintJob::with('currentStatus')->where('status', $status->id)->paginate(20, ['*'], str_slug($status->name));
        }
        return view('admin.index', compact('printJobs', 'statuses'));
    }

    /**
     * Edit the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $printJob = PrintJob::find($id);
        $newStatus = $request->get('status');


        return view('admin.edit');
    }

    public function update(Request $request, $id)
    {
        $printJob = PrintJob::find($id);
        $originalStatus = $printJob->status;
        $printJob->status = $request->status;
        $printJob->save();

        return redirect()->route('admin', ["#$originalStatus"]);
        
    }
}
