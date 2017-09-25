@extends('layouts.admin')

@section('title')
    3D Printing Stats
@endsection

@section('content')

    {!! $printJobsByMonth->html() !!}
    {!! $currentStatuses->html() !!}
    {!! $filamentQuantityByColor->html() !!}

    @foreach($filamentUsage as $chart)
        {!! $chart->html() !!}
    @endforeach

@endsection

@push('styles')
    {!! Charts::styles() !!}
 
@endpush

@push('custom-scripts')
    {!! Charts::scripts() !!}

    {!! $printJobsByMonth->script() !!}
    {!! $currentStatuses->script() !!}
    {!! $filamentQuantityByColor->script() !!}

    @foreach($filamentUsage as $chart)
        {!! $chart->script() !!}
    @endforeach

@endpush