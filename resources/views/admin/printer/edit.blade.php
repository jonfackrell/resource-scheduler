@extends('layouts.admin')

@section('title')
    Printer
@endsection

@section('content')

	{!! BootForm::open()->action(route('printer.update', $printer))->put() !!}
	  {!! BootForm::bind($printer) !!}
	  {!! BootForm::text('Name', 'name') !!}
	  {!! BootForm::text('Description', 'description') !!}
	  
	  
	  {!! BootForm::submit('Submit') !!}
	  
	{!! BootForm::close() !!} 

@endsection