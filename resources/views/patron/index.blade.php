@extends('layouts.admin')

@section('title')
    Patron
@endsection

@section('content')

	{!! BootForm::open()->action(route('patron.index'))->post() !!}
	  {!! BootForm::text('First Name', 'first_name') !!}
  	  {!! BootForm::text('Last Name', 'last_name') !!}
      {!! BootForm::email('Email', 'email') !!}
      {!! BootForm::select('Department', 'department')->options($departments) !!}
      {!! BootForm::submit('Submit') !!}
	{!! BootForm::close() !!} 

	

@endsection
