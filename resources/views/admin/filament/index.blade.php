@extends('layouts.admin')

@section('content')

	{!! BootForm::open()->action('admin/filament')->post() !!}
	  {!! BootForm::text('Name', 'name') !!}
	  {!! BootForm::textarea('Description', 'description') !!}
	  {!! BootForm::text('Quantity', 'quantity') !!}
	  
	{!! BootForm::close() !!} 

	@foreach($filaments as $filament)

        <p>
            <a href="/admin/filament/{{ $filament->id }}/edit">{{ $filament->name }}</a>
        </p>

    @endforeach

@endsection