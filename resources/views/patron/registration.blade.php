@extends('layouts.public')

@section('title')
    Edit Profile
@endsection

@section('content')

    {!! BootForm::open()->action(route('register'))->put() !!}
    {!! BootForm::bind($user) !!}
    {!! BootForm::text('First Name', 'first_name') !!}
    {!! BootForm::text('Last Name', 'last_name') !!}
    {!! BootForm::text('Email', 'email') !!}
    {!! BootForm::text('I-Number', 'inumber') !!}
    {!! BootForm::hidden('netid') !!}
    {!! BootForm::submit('Save')->class('btn btn-success') !!}
    {!! BootForm::close() !!}
@endsection