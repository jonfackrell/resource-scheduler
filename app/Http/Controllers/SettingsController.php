<?php

namespace App\Http\Controllers;

use App\Models\EmailSetting;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::all();
        $email = EmailSetting::first();
        return view('admin.settings.index', compact('settings', 'email'));
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
    public function update(Request $request)
    {

        $settings                   = Setting::firstOrNew(['name' => 'HEADER_HTML']);
        $settings->name             = 'HEADER_HTML';
        $settings->value            = $request->get('HEADER_HTML');
        $settings->group            = 'PUBLIC';
        $settings->order            = 1;
        $settings->save();

        $settings                   = Setting::firstOrNew(['name' => 'HEADER_CSS']);
        $settings->name             = 'HEADER_CSS';
        $settings->value            = $request->get('HEADER_CSS');
        $settings->group            = 'PUBLIC';
        $settings->order            = 2;
        $settings->save();

        $settings                   = Setting::firstOrNew(['name' => 'FOOTER_HTML']);
        $settings->name             = 'FOOTER_HTML';
        $settings->value            = $request->get('FOOTER_HTML');
        $settings->group            = 'PUBLIC';
        $settings->order            = 3;
        $settings->save();

        $settings                   = Setting::firstOrNew(['name' => 'FOOTER_JS']);
        $settings->name             = 'FOOTER_JS';
        $settings->value            = $request->get('FOOTER_JS');
        $settings->group            = 'PUBLIC';
        $settings->order            = 4;
        $settings->save();

        $settings                   = Setting::firstOrNew(['name' => 'LOGO']);
        $settings->name             = 'LOGO';
        $settings->value            = $request->get('LOGO');
        $settings->group            = 'PUBLIC';
        $settings->order            = 5;
        $settings->save();

        $email                      = EmailSetting::firstOrNew(['from_address' => $request->get('from_address')]);
        $email->outgoing_host       = $request->get('outgoing_host');
        $email->outgoing_port       = $request->get('outgoing_port');
        $email->incoming_host       = $request->get('outgoing_host');
        $email->incoming_port       = $request->get('outgoing_port');
        $email->from_address        = $request->get('from_address');
        $email->from_name           = $request->get('from_name');
        $email->encryption          = $request->get('encryption');
        $email->username            = $request->get('username');
        $email->password            = $request->get('password');
        $email->default             = true;
        $email->enabled             = true;
        $email->save();

        return redirect()->back();
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
}
