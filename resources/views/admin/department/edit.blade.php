@extends('layouts.admin')

@section('title')
    Departments
@endsection

@section('content')

	{!! BootForm::open()->action(route('department.update', $department))->put() !!}
        {!! BootForm::bind($department) !!}
        {!! BootForm::text('Name', 'name') !!}
        {!! BootForm::textarea('Description', 'description')->addClass('summernote') !!}
        {!! BootForm::textarea('Terms', 'terms')->addClass('summernote') !!}
        {!! BootForm::textarea('Payment Instructions', 'payment_instructions')->addClass('summernote') !!}
        {!! BootForm::text('Tax Rate', 'tax_rate')->required()->helpBlock('For a 6% tax input 1.06. The cost to print will be multipled by the value entered here.') !!}
	    {!! BootForm::select('Initial Status', 'initial_status')->options($statuses)->select($department->initial_status) !!}
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