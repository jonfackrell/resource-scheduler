@extends('layouts.admin')

@section('title')
    Printer
@endsection

@section('content')

	{!! BootForm::open()->action(route('printer.update', $printer))->put() !!}
	    {!! BootForm::bind($printer) !!}
	    {!! BootForm::text('Name', 'name')->required() !!}
	    {!! BootForm::textarea('Description', 'description')->addClass('summernote')->required() !!}
	    {!! BootForm::text('Image URL', 'image')->required() !!}
        {!! BootForm::text('Flat Printing Fee', 'flat_fee')->hint('You can add a flat printing fee to use this printer. Value should be in cents.') !!}
        {!! BootForm::text('Per Hour Fee', 'per_hour')->hint('You can charge a per hour fee to use this printer. Value should be in cents.') !!}
        {!! BootForm::text('Overtime Fee', 'overtime_fee')->hint('Alternatively, you can charge a fee for every X hours. For example, add $1 for every 12 hours of printing. Value should be in cents.') !!}
        {!! BootForm::text('Start Charging Overtime At', 'overtime_start')->hint('If charging an overtime fee, specficy the interval for when the fee should be applied. Value should be in hours.') !!}
	    {!! BootForm::submit('Submit') !!}
	{!! BootForm::close() !!} 

@endsection

@push('styles')
    <link rel="stylesheet" href="/css/summernote.css" />
    <style>
        .note-group-select-from-files{display: none;}
    </style>
@endpush

@push('custom-scripts')
    <script src="/js/summernote.js"></script>
    <script>
        $(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.summernote').summernote({
                height: 200
            });
        });
    </script>
@endpush