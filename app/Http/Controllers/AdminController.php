<?php

namespace App\Http\Controllers;

use App\Events\FilamentUsed;
use App\Models\PrintJob;
use App\Models\Status;
use App\Notifications\GenericNotification;
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
            $printJobs[$status->id] = PrintJob::with('currentStatus', 'owner', 'getFilament')->where('status', $status->id)->paginate(20, ['*'], str_slug($status->name));
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
        $printJob = PrintJob::findOrFail($id);
        $newStatus = $request->get('status');
        $status = Status::findOrFail($newStatus);
        if($status->systemNotification){
            return view('admin.edit', compact('printJob', 'newStatus'));
        }else{
            $originalStatus = $printJob->status;
            $printJob->status = $newStatus;
            $printJob->save();
            if($status->subtract_inventory){
                event(new FilamentUsed($printJob));
            }
            return redirect()->route('admin', ["#$originalStatus"]);
        }

    }

    public function update(Request $request, $id)
    {
        $newStatus = $request->get('new_status');
        $status = Status::findOrFail($newStatus);
        $printJob = PrintJob::findOrFail($id);
        $originalStatus = $printJob->status;
        $printJob->status = $newStatus;
        $printJob->save();

        if($printJob->currentStatus->systemNotification){
            $printJob->owner->notify(new $printJob->currentStatus->systemNotification->name($printJob, $request->get('subject'), $request->get('message')));
        }

        if($status->subtract_inventory){
            event(new FilamentUsed($printJob));
        }

        return redirect()->route('admin', ["#$originalStatus"]);
        
    }

    /**
     * Create email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createEmail(Request $request, $id)
    {
        $printJob = PrintJob::findOrFail($id);

        return view('admin.create-email', compact('printJob'));

    }

    /**
     * Send email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendEmail(Request $request, $id)
    {
        $printJob = PrintJob::findOrFail($id);

        $printJob->owner->notify(new GenericNotification($printJob, $request->get('subject'), $request->get('message')));

        return redirect()->route('admin.index', ["#$printJob->status"]);

    }
}
