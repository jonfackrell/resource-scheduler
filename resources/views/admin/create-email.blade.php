@extends('layouts.admin')

@section('title')
    Updating Status & Sending Email
@endsection

@section('content')

    {!! BootForm::open()->action(route('admin.send-email', $printJob->id))->post() !!}
    {!! BootForm::text('Subject', 'subject') !!}
    {!! BootForm::textarea('Message', 'message')->addClass('summernote') !!}
    {!! BootForm::submit('Send')->class('btn btn-primary') !!}
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