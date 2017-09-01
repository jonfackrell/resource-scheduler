<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view-statuses');

        $statuses = Status::orderBy('order_column')->get();
        return view('admin.status.index', compact('statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create-statuses');

        $status = new Status();
        $status->fill($request->all());
        $status->department = auth()->user()->department;
        $status->save();

        return redirect()->route('status.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('edit-statuses');

        $status = Status::findOrFail($id);
        return view('admin.status.edit', compact('status'));
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
        $this->authorize('edit-statuses');

        $status = Status::find($id);
        $status->fill($request->all());
        $status->save();

        if($request->ajax()){
            return response()->json(['status' => true]);
        }

        return redirect()->route('status.index');
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
        $this->authorize('edit-statuses');

        $order = json_decode($request->get('order'))[0];
        foreach($order as $key => $row){
            $status = Status::find($row->id);
            $status->order_column = $key;
            $status->save();
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
        $this->authorize('delete-statuses');

        $status = Status::findorFail($id);
        $status->delete();

        return redirect()->back();
    }
}
