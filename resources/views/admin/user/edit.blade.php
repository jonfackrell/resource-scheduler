@extends('layouts.admin')

@section('title')
    Users
@endsection

@section('content')
    {!! BootForm::open()->action(route('user.update', $user))->put() !!}
    {!! BootForm::bind($user) !!}
    {!! BootForm::text('First Name', 'first_name')->required() !!}
    {!! BootForm::text('Last Name', 'last_name')->required() !!}
    {!! BootForm::email('Email', 'email') !!}
    {!! BootForm::select('Role', 'role')->options($roles)->select($user->role->name) !!}
    {!! BootForm::select('Department', 'department')->options($departments) !!}


    {!! BootForm::submit('Submit') !!}

    {!! BootForm::close() !!}

@endsection