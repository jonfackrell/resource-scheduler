<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view-notifications');

        $notifications = Notification::whereDepartment(auth()->guard('web')->user()->department)->orderBy('order_column')->get();

        return view('admin.notification.index', compact('notifications'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create-notifications');

        $notification = new Notification();
        $notification->fill($request->all());
        $notification->department = auth()->guard('web')->user()->department;
        $notification->save();

        return redirect()->route('notification.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('edit-notifications');

        $notification = Notification::findOrFail($id);
        return view('admin.notification.edit', compact('notification'));
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
        $this->authorize('edit-notifications');

        $notification = Notification::find($id);
        $notification->fill($request->all());
        $notification->save();

        if($request->ajax()){
            return response()->json(['status' => true]);
        }

        return redirect()->route('notification.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-notifications');

        $notification = Notification::findorFail($id);
        $notification->delete();

        return redirect()->back();
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
        $this->authorize('edit-notiifcations');

        $order = json_decode($request->get('order'))[0];
        foreach($order as $key => $row){
            $notification = Notification::find($row->id);
            $notification->order_column = $key;
            $notification->save();
        }
        return response()->json(['status' => true]);
    }

}
