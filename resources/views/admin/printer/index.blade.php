@extends('layouts.admin')

@section('title')
	Printer
@endsection

@section('content')

	{!! BootForm::open()->action(route('printer.index'))->post() !!}
	  {!! BootForm::text('Name', 'name') !!}
	  {!! BootForm::textarea('Description', 'description') !!}
	  
	  {!! BootForm::submit('Submit') !!}
	{!! BootForm::close() !!} 

	@foreach($printers as $printer)

        <p>
            <a href="/admin/printer/{{ $printer->id }}/edit">{{ $printer->name }}</a>
        </p>

    @endforeach

@endsection