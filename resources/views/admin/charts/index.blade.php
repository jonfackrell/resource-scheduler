@extends('layouts.admin')

@section('title')
    3D Printing Stats
@endsection

@section('content')

    {!! $chart->html() !!}

    {!! $chart2->html() !!}
    {!! $chart3->html() !!}
    {!! $filamentChart1->html() !!}


    
@endsection

@push('styles')
    {!! Charts::styles() !!}
 
@endpush

@push('custom-scripts')
    {!! Charts::scripts() !!}
    {!! $chart->script() !!}

    {!! $chart2->script() !!}
    {!! $chart3->script() !!}
    {!! $filamentChart1->script() !!}
 
@endpush