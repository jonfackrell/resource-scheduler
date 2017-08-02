@extends('layouts.admin')

@section('title')
    Users
@endsection

@section('content')

	{!! BootForm::open()->action(route('user.update', $user))->put() !!}
	  {!! BootForm::bind($user) !!}
	  {!! BootForm::text('Firstname', 'first_name')->required() !!}
	  {!! BootForm::text('Lastname', 'last_name')->required() !!}
	  {!! BootForm::email('Email', 'email') !!}
      
	  {!! BootForm::select('Department', 'department')->options($departments) !!}
	  
	  
	  {!! BootForm::submit('Submit') !!}
	  
	{!! BootForm::close() !!} 

@endsection