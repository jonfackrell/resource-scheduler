@extends('layouts.admin')

@section('title')
    Edit Print Job
@endsection

@section('content')
    <h2>{{ $patron->first_name . ' ' . $patron->last_name}}</h2>
    <a href="mailto:{{ $patron->email }}"><i class="fa fa-envelope"></i> {{ $patron->email }}</a>
    <br />
    <br />
    {!! BootForm::open()->action(route('uploadfile.update', $printjob))->put()->enctype('multipart/form-data') !!}
    {!! BootForm::bind($printjob) !!}
    {!! BootForm::select('Department', 'department')->options($departments) !!}
    {!! BootForm::file('File', 'filename') !!}
    {!! BootForm::submit('Submit')->class('btn btn-success') !!}
    {!! BootForm::close() !!}
@endsection