@extends('layouts.admin')

@section('title')
	Filaments
@endsection

@section('content')

	{!! BootForm::open()->action(route('filament.index'))->post() !!}
	  {!! BootForm::text('Name', 'name') !!}
	  {!! BootForm::textarea('Description', 'description') !!}
	  {!! BootForm::text('Quantity', 'quantity') !!}
	  {!! BootForm::submit('Submit') !!}
	{!! BootForm::close() !!} 

	@foreach($filaments as $filament)

        <p>
            <a href="/admin/filament/{{ $filament->id }}/edit">{{ $filament->name }}</a>
        </p>

    @endforeach

@endsection