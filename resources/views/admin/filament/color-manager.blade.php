@extends('layouts.admin')

@section('title')
	Filament Color Manager
@endsection

@section('content')
    <div class="alert alert-info">
        The colors specified below are shared by all of the printers that print <b>{{ $filament->name }}</b>
    </div>

    {!! BootForm::open()->action(route('filament.color-manager', ['filamentid' => $filament->id, 'printerid' => $printer->id]))->post() !!}
    {!! BootForm::submit('Update', 'update')->class('btn btn-success btn-sm') !!}
        <table class="table table-striped">
            <thead>
            <tr>
                <td></td>
                <td>Quantity</td>
            </tr>
            </thead>
            <tbody>
            @foreach($colors as $color)
                <tr data-id="{{ $color->id }}">
                    <th style="vertical-align: middle; max-width: 200px;">
                        <div style="height: 20px; width: 20px; margin-right: 10px; display: inline-block;  background-color: #{{ $color->hex_code }}" ></div>
                        {{ $color->name }}
                    </th>
                    <td>
                        {!! BootForm::text('Quantity', 'quantity_' . $color->colorid)->hideLabel()->value($color->quantity) !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot></tfoot>
        </table>
    {!! BootForm::submit('Update', 'update')->class('btn btn-success btn-sm') !!}
    {!! BootForm::close() !!}

@endsection

@push('styles')

@endpush

@push('custom-scripts')

@endpush