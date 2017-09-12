<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = \App\Models\Patron::whereNetid(auth()->guard('patrons')->user()->netid)->first();
        $public = Setting::where('group', 'PUBLIC')->get();
        return view('patron.registration', compact('user', 'public'));
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
        $user = \App\Models\Patron::whereNetid($request->get('netid'))->first();
        $user->fill($request->all());
        $user->save();

        return redirect('/');
    }
}