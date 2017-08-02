@extends('layouts.admin')

@section('title')
    Filaments
@endsection

@section('content')

	{!! BootForm::open()->action(route('filament.update', $filament))->put() !!}
	  {!! BootForm::bind($filament) !!}
	  {!! BootForm::text('Name', 'name') !!}
	  {!! BootForm::text('Description', 'description') !!}
	  {!! BootForm::text('Quantity', 'quantity') !!}
	  {!! BootForm::text('Created at', 'created_at') !!}
	  {!! BootForm::text('Updated at', 'updated_at') !!}
	  {!! BootForm::text('Deleted at', 'deleted_at') !!}
	  {!! BootForm::submit('Submit') !!}
	  
	{!! BootForm::close() !!} 

@endsection