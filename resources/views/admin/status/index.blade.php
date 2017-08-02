@extends('layouts.admin')

@section('title')
	Statuses
@endsection

@section('content')

	{!! BootForm::open()->action(route('status.index'))->post() !!}
	  {!! BootForm::text('Name', 'name') !!}
	  {!! BootForm::submit('Submit') !!}
	{!! BootForm::close() !!} 

	@foreach($statuses as $status)

        <p>
            <a href="/admin/status/{{ $status->id }}/edit">{{ $status->name }}</a>
        </p>

    @endforeach

@endsection