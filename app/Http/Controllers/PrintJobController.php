<?php

namespace App\Http\Controllers;

use App\Models\PrintJob;
use Illuminate\Http\Request;

class PrintJobController extends Controller
{
    public function showUploadForm() {
   
    	return view('upload');

    }

    public function storeFile(Request $request) {
    	
    	if($request->hasFile('filename')) {

    	    //$filename = $request->filename->getClientOriginalName();
            //$filesize = $request->filename->getClientSize();
    		$filename = $request->filename->store('public/upload');

    		$file = PrintJob::find(1);
    		$file->filename = $filename;
    		$file->department = 3;
    		$file->save();


            return 'yes';

    	}

    	return $request->all();


    }
}
