@extends('layouts.admin')

@section('content')

	{!! BootForm::open()->action('admin/department', $department)->put() !!}
	  {!! BootForm::bind($department) !!}
	  {!! BootForm::text('Name', 'name') !!}
	  {!! BootForm::text('Description', 'description') !!}
	  {!! BootForm::date('Date of Birth', 'date_of_birth') !!}
	  {!! BootForm::email('Email', 'email') !!}
	  {!! BootForm::password('Password', 'password') !!}
	  {!! BootForm::submit('Submit') !!}
	{!! BootForm::close() !!} 

@endsection