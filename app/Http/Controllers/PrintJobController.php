<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrintJobController extends Controller
{
    public function showUploadForm() {
   
    	return view('upload');

    }

    public function storeFile(Request $request) {
    	
    	if($request->hasFile('filename')) {

    		return $request->filename->store('public/upload');

    		 // return 'yes';

    	}


    }
}
