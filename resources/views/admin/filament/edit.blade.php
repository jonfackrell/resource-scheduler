@extends('layouts.admin')

@section('title')
    Filaments
@endsection

@section('content')

	{!! BootForm::open()->action(route('filament.update', $filament))->put() !!}
	    {!! BootForm::bind($filament) !!}
	    {!! BootForm::text('Name', 'name') !!}
	    {!! BootForm::text('Description', 'description') !!}
        {!! BootForm::text('Cost per Gram', 'cost_per_gram' )->hideLabel()->value($filament->cost_per_gram)->helpBlock('This should be the amount the filament costs per gram for you to buy. Should be in cents.') !!}
        {!! BootForm::text('Additional Cost per Gram', 'add_cost_per_gram')->hideLabel()->value($color->add_cost_per_gram)->helpBlock('This is any additional fee you want to charge on top of the cost per per gram. Should be in cents.') !!}
        {!! BootForm::text('Multiplier', 'multiplier')->hideLabel()->value($color->multiplier)->helpBlock('This value is multiplied by the cost and then weight to calculate cost.') !!}
	    {!! BootForm::submit('Submit') !!}
	{!! BootForm::close() !!} 

@endsection