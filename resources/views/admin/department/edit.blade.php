@extends('layouts.admin')

@section('title')
    Departments
@endsection

@section('content')

	{!! BootForm::open()->action(route('department.update', $department))->put() !!}
	  {!! BootForm::bind($department) !!}
	  {!! BootForm::text('Name', 'name') !!}
	  {!! BootForm::text('Description', 'description') !!}
	  {!! BootForm::text('Created at', 'created_at') !!}
	  {!! BootForm::text('Updated at', 'updated_at') !!}
	  {!! BootForm::text('Deleted at', 'deleted_at') !!}
	  {!! BootForm::submit('Submit') !!}
	{!! BootForm::close() !!} 

@endsection