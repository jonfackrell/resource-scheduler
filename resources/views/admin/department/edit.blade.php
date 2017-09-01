@extends('layouts.admin')

@section('title')
    Departments
@endsection

@section('content')

	{!! BootForm::open()->action(route('department.update', $department))->put() !!}
	  {!! BootForm::bind($department) !!}
	  {!! BootForm::text('Name', 'name') !!}
	  {!! BootForm::text('Description', 'description') !!}
	  {!! BootForm::select('Initial Status', 'initial_status')->options($statuses)->select($department->initial_status) !!}

	  {!! BootForm::submit('Submit') !!}
	{!! BootForm::close() !!} 

@endsection