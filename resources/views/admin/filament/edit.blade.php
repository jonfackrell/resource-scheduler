@extends('layouts.admin')

@section('content')

	{!! BootForm::open()->action(route('filament.update', $filament))->put() !!}
	  {!! BootForm::bind($filament) !!}
	  {!! BootForm::text('Name', 'name') !!}
	  {!! BootForm::text('Description', 'description') !!}
	  
	  {!! BootForm::submit('Submit') !!}
	  
	{!! BootForm::close() !!} 

@endsection