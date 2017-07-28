@extends('layouts.admin')

@section('content')

	{!! BootForm::open()->action('admin/filament')->post() !!}
	  {!! BootForm::text('Type', 'first_name') !!}
	  {!! BootForm::text('Cost', 'last_name') !!}
	  {!! BootForm::date('Color', 'date_of_birth') !!}
	  {!! BootForm::email('Email', 'email') !!}
	  {!! BootForm::password('Password', 'password') !!}
	  {!! BootForm::submit('Submit') !!}
	{!! BootForm::close() !!} 

	@foreach($filaments as $filament)

        <p>
            <a href="/admin/filament/{{ $filament->id }}/edit">{{ $filament->name }}</a>
        </p>

    @endforeach

@endsection