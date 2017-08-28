@extends('layouts.admin')

@section('title')
    Tell us a little about your model
@endsection

@section('content')

    {!! BootForm::open()->action(route('printers'))->post()->enctype('multipart/form-data') !!}
    {!! BootForm::text('Estimated Time', 'time')->required() !!}
    {!! BootForm::text('Weight (in grams)', 'weight')->required() !!}
    {!! BootForm::submit('Submit') !!}
    {!! BootForm::close() !!}

@endsection