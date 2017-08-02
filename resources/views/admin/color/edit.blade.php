@extends('layouts.admin')

@section('content')

	{!! BootForm::open()->action(route('color.update', $color))->put() !!}
	  {!! BootForm::bind($color) !!}
	  {!! BootForm::text('Name', 'name') !!}
	  {!! BootForm::text('Description', 'description') !!}
	  
	  {!! BootForm::submit('Submit') !!}
	{!! BootForm::close() !!} 

@endsection