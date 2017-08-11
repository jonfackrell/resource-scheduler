@extends('layouts.admin')

@section('title')
    Edit upload
@endsection

@section('content')

    {!! BootForm::open()->action(route('uploadfile.update', $printjob))->put()->enctype('multipart/form-data') !!}
    {!! BootForm::bind($printjob) !!}
    {!! BootForm::file('File', 'filename') !!}
    {!! BootForm::text('Patron', 'patron') !!}
    {!! BootForm::select('Filament', 'filament')->options($filaments) !!}
    {!! BootForm::text('Color', 'color') !!}

    {!! BootForm::select('Department', 'department')->options($departments) !!}


    {!! BootForm::submit('Submit') !!}

    {!! BootForm::close() !!}

@endsection