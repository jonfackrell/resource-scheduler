<?php

namespace App\Http\Controllers;

use App\Models\Printer;
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

    /**
     * Display all printers
     *
     * @return \Illuminate\Http\Response
     */
    public function printers()
    {
        $public = Setting::where('group', 'PUBLIC')->get();
        $printers = Printer::all();
        return view('public.printers', compact('public', 'printers'));
    }

    /**
     * Display policy
     *
     * @return \Illuminate\Http\Response
     */
    public function policy()
    {
        $public = Setting::where('group', 'PUBLIC')->get();
        return view('public.policy', compact('public'));
    }
}
