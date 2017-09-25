@extends('layouts.public')

@section('title')
    Contact Us
@endsection

@section('content')

    {!! BootForm::open()->action(route('send-email'))->post() !!}
    {!! BootForm::text('Name', 'name')->value(auth()->guard('patrons')->user()->full_name)->required() !!}
    {!! BootForm::email('Email', 'email')->value(auth()->guard('patrons')->user()->email)->required() !!}
    {!! BootForm::textarea('Question', 'message')->required() !!}
    {!! BootForm::submit('Send')->class('btn btn-success') !!}
    {!! BootForm::close() !!}

@endsection
