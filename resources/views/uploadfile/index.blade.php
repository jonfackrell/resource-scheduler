@extends('layouts.admin')

@section('title')
    Upload File
@endsection

@section('content')
<div>
<p><b>Patron<br></b>{{ $patron->first_name . ' ' . $patron->last_name}}</p>
</div>

    {!! BootForm::open()->action(route('uploadfile.index'))->post()->enctype('multipart/form-data') !!}
    {{--{!! BootForm::bind($patron) !!}--}}

    

    {!! BootForm::text('Patron id', 'patron')->value($patron->id) !!}

    {!! BootForm::select('Department', 'department')->options($departments)->select(6) !!}

    {!! BootForm::select('Filament', 'filament')->options($filaments) !!}
    {!! BootForm::text('Color', 'color') !!}
    
    {!! BootForm::file('File', 'filename')->required() !!}
    

    {!! BootForm::submit('Submit') !!}
    {!! BootForm::close() !!}

    @foreach($printjobs as $printjob)

        <p>
            <a href="/uploadfile/{{ $printjob->id }}/edit">{{ $printjob->patron }} {{ $printjob->department }}</a>
        </p>

    @endforeach

@endsection