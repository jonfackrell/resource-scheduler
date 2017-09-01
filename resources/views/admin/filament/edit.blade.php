@extends('layouts.admin')

@section('title')
    Filaments
@endsection

@section('content')

	{!! BootForm::open()->action(route('filament.update', $filament))->put() !!}
	    {!! BootForm::bind($filament) !!}
	    {!! BootForm::text('Name', 'name') !!}
	    {!! BootForm::text('Description', 'description') !!}
        {!! BootForm::text('Cost per Gram', 'cost_per_gram' )->hideLabel()->value($filament->cost_per_gram) !!}
        {!! BootForm::text('Additional Cost per Gram', 'add_cost_per_gram')->hideLabel()->value($color->add_cost_per_gram) !!}
        {!! BootForm::text('Multiplier', 'multiplier')->hideLabel()->value($color->multiplier) !!}
	    {!! BootForm::submit('Submit') !!}
	{!! BootForm::close() !!} 

@endsection