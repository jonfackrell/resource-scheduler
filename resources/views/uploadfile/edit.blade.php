@extends('layouts.admin')

@section('title')
    Edit upload
@endsection

@section('content')

<div>
<p><b>Patron<br></b>{{ $patron->first_name . ' ' . $patron->last_name}}</p>
</div>
    {!! BootForm::open()->action(route('uploadfile.update', $printjob))->put()->enctype('multipart/form-data') !!}
    {!! BootForm::bind($printjob) !!}
    
    {!! BootForm::text('Patron', 'patron') !!}
    {!! BootForm::select('Department', 'department')->options($departments) !!}
    {!! BootForm::select('Filament', 'filament')->options($filaments) !!}
    {!! BootForm::text('Color', 'color') !!}

    
    {!! BootForm::file('File', 'filename') !!}


    {!! BootForm::submit('Submit') !!}

    {!! BootForm::close() !!}

@endsection