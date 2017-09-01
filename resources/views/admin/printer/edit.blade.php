@extends('layouts.admin')

@section('title')
    Printer
@endsection

@section('content')

	{!! BootForm::open()->action(route('printer.update', $printer))->put() !!}
	    {!! BootForm::bind($printer) !!}
	    {!! BootForm::text('Name', 'name') !!}
	    {!! BootForm::textarea('Description', 'description')->addClass('summernote') !!}
	    {!! BootForm::text('Image URL', 'image') !!}
        {!! BootForm::text('Flat Printing Fee', 'flat_fee') !!}
        {!! BootForm::text('Per Hour Fee', 'per_hour') !!}
        {!! BootForm::text('Overtime Fee', 'overtime_fee') !!}
        {!! BootForm::text('Start Charging Overtime At', 'overtime_start') !!}
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