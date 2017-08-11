@extends('layouts.admin')

@section('title')
    Upload File
@endsection

@section('content')

    {!! BootForm::open()->action(route('uploadfile.store'))->post()->enctype('multipart/form-data') !!}
    {{--{!! BootForm::bind($printjobs) !!}--}}

    {!! BootForm::file('File', 'filename')->required() !!}

    {!! BootForm::text('Patron', 'patron')->value($patrons->first_name) !!}
    {!! BootForm::select('Filament', 'filament')->options($filaments) !!}
    {!! BootForm::text('Color', 'color') !!}
    {!! BootForm::select('Department', 'department')->options($departments) !!}
    {!! BootForm::submit('Submit') !!}
    {!! BootForm::close() !!}

    @foreach($printjobs as $printjob)

        <p>
            <a href="/uploadfile/{{ $printjob->id }}/edit">{{ $printjob->patron }} {{ $printjob->filament }}</a>
        </p>

    @endforeach

@endsection