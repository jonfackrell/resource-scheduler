@extends('layouts.admin')

@section('title')
    3D Printing Stats
@endsection

@section('content')

    {!! $chart->html() !!}

    {!! $chart2->html() !!}

    
@endsection

@push('styles')
    {!! Charts::styles() !!}
 
@endpush

@push('custom-scripts')
    {!! Charts::scripts() !!}
    {!! $chart->script() !!}

    {!! $chart2->script() !!}
 
@endpush