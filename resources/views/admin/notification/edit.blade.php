@extends('layouts.admin')

@section('title')
    Statuses
@endsection

@section('content')
    {!! BootForm::open()->action(route('notification.update', $notification))->put() !!}
    {!! BootForm::bind($notification) !!}
        <div class="row">
            <div class="col-md-6">
                {!! BootForm::text('Display Name', 'display_name')->required() !!}
                {!! BootForm::text('Subject', 'subject')->required() !!}
                {!! BootForm::textarea('Message', 'message')->addClass('summernote')->required() !!}
            </div>
        </div>
    {!! BootForm::submit('Submit')->class('btn btn-success') !!}
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