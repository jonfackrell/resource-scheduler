<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Display the Homepage
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $public = Setting::where('group', 'PUBLIC')->get();
        return view('public.index', compact('public'));
    }
}
