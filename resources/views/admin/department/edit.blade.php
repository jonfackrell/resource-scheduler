@extends('layouts.admin')

@section('content')

	{!! BootForm::open()->action(route('department.update', $department))->put() !!}
	  {!! BootForm::bind($department) !!}
	  {!! BootForm::text('Name', 'name') !!}
	  {!! BootForm::text('Description', 'description') !!}
	  
	  {!! BootForm::submit('Submit') !!}
	{!! BootForm::close() !!} 

@endsection