<?php

namespace App\Http\Controllers;

use App\Models\PrintJob;
use App\Models\Status;
use App\Notifications\PaymentReceivedNotification;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $statuses = Status::whereAcceptPayment(1)
                            ->whereDepartment(auth()->guard('web')->user()->department)
                            ->pluck('id')
                            ->all();
        $printJobs = PrintJob::with('currentStatus', 'owner')
                        ->whereIn('status', $statuses)
                        ->where('paid', '<>', 1);
        if($request->has('q')){
            $printJobs = $printJobs->whereHas('owner', function($query) use ($request){
                $query->where('first_name', 'LIKE', '%'.$request->get('q').'%')->orWhere('last_name', 'LIKE', '%'.$request->get('q').'%');
            });
        }
        $printJobs = $printJobs->paginate(20);
        return view('admin.payment.index', compact('printJobs'));
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


    public function updatePaymentStatus(Request $request)
    {
        $printJob = PrintJob::findOrFail($request->get('id'));
        $printJob->paid = $request->get('paid');
        $printJob->save();

        if($printJob->paid == 1){
            $printJob->owner->notify(new PaymentReceivedNotification($printJob));
        }

        return response()->json(['status' => $request->get('paid')]);
    }
}
