@extends('layouts.admin')

@section('title')
	Filament Pricing Manager
@endsection

@section('content')

    {!! BootForm::open()->action(route('filament.pricing-manager', ['filamentid' => $filament->id, 'printerid' => $printer->id]))->post() !!}
    {!! BootForm::text('Cost per Gram', 'cost_per_gram')->value($pricingOptions->cost_per_gram)->helpBlock('This should be the amount the filament costs per gram for you to buy. Should be in cents.') !!}
    {!! BootForm::text('Additional Cost per Gram', 'add_cost_per_gram')->value($pricingOptions->add_cost_per_gram)->helpBlock('This is any additional fee you want to charge on top of the cost per per gram. Should be in cents.') !!}
    {!! BootForm::text('Multiplier', 'multiplier')->value($pricingOptions->multiplier)->helpBlock('This value is multiplied by the cost and then weight to calculate cost.') !!}
    {!! BootForm::hidden('pricing_options_id')->value($pricingOptions->id) !!}
    {!! BootForm::submit('Update', 'update')->class('btn btn-success btn-sm') !!}
    {!! BootForm::close() !!}

@endsection

@push('styles')

@endpush

@push('custom-scripts')

@endpush