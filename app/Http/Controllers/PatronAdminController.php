<?php

namespace App\Http\Controllers;

use App\CostCalculator;
use App\Events\PrintJobCreated;
use App\Models\Color;
use App\Models\Filament;
use App\Models\Printer;
use App\Models\PrintJob;
use App\Models\Setting;
use App\Models\Status;
use App\Notifications\GenericNotification;
use App\Notifications\QuestionNotification;
use Illuminate\Http\Request;
use App\Models\Patron;
use App\Models\Department;
use Illuminate\Validation\Validator;

class PatronAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patrons = Patron::paginate(30);
        return view('admin.patrons.index', compact('patrons'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
        $patron = Patron::findorFail($id);
        $patron->delete();

        return redirect()->back();
    }

}
