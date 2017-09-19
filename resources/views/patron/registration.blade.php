@extends('layouts.public')

@section('title')
    Edit Profile
@endsection

@section('content')

    {!! BootForm::open()->action(route('register'))->put() !!}
    {!! BootForm::bind($user) !!}
    {!! BootForm::text('First Name', 'first_name')->required() !!}
    {!! BootForm::text('Last Name', 'last_name')->required() !!}
    {!! BootForm::email('Email', 'email')->required() !!}
    {!! BootForm::text('I-Number', 'inumber')->required() !!}
    {!! BootForm::hidden('netid') !!}
    {!! BootForm::submit('Save')->class('btn btn-success') !!}
    {!! BootForm::close() !!}
@endsection