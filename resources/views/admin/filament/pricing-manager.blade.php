@extends('layouts.admin')

@section('title')
	Filament Pricing Manager
@endsection

@section('content')

    {!! BootForm::open()->action(route('filament.pricing-manager', ['filamentid' => $filament->id, 'printerid' => $printer->id]))->post() !!}
    {!! BootForm::text('Cost per Gram', 'cost_per_gram')->value($pricingOptions->cost_per_gram) !!}
    {!! BootForm::text('Additional Cost per Gram', 'add_cost_per_gram')->value($pricingOptions->add_cost_per_gram) !!}
    {!! BootForm::text('Multiplier', 'multiplier')->value($pricingOptions->multiplier) !!}
    {!! BootForm::hidden('pricing_options_id')->value($pricingOptions->id) !!}
    {!! BootForm::submit('Update', 'update')->class('btn btn-success btn-sm') !!}
    {!! BootForm::close() !!}

@endsection

@push('styles')

@endpush

@push('custom-scripts')

@endpush