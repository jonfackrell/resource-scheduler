@extends('layouts.admin')

@section('title')
    System Settings
@endsection

@section('content')

    @if(auth()->guard('web')->user()->isSuperUser())
        {!! BootForm::open()->action(route('settings.index'))->post() !!}
            {!! BootForm::text('Logo', 'LOGO')->defaultValue(((isset($settings->where('name', 'LOGO')->first()->value))?$settings->where('name', 'LOGO')->first()->value:'')) !!}
            {!! BootForm::textarea('Header HTML', 'HEADER_HTML')->addClass('summernote')->defaultValue(((isset($settings->where('name', 'HEADER_HTML')->first()->value))?$settings->where('name', 'HEADER_HTML')->first()->value:'')) !!}
            {!! BootForm::textarea('Custom CSS', 'HEADER_CSS')->defaultValue(((isset($settings->where('name', 'HEADER_CSS')->first()->value))?$settings->where('name', 'HEADER_CSS')->first()->value:'')) !!}
            {!! BootForm::textarea('Footer HTML', 'FOOTER_HTML')->addClass('summernote')->defaultValue(((isset($settings->where('name', 'FOOTER_HTML')->first()->value))?$settings->where('name', 'FOOTER_HTML')->first()->value:'')) !!}
            {!! BootForm::textarea('Custom JavaScript', 'FOOTER_JS')->defaultValue(((isset($settings->where('name', 'FOOTER_JS')->first()->value))?$settings->where('name', 'FOOTER_JS')->first()->value:'')) !!}

            @php
                if(!is_null($email)){
                    BootForm::bind($email);
                }
            @endphp
            {!! BootForm::text('Email Address', 'from_address')->required(true) !!}
            {!! BootForm::text('Name', 'from_name')->required(true) !!}
            {!! BootForm::text('Username', 'username')->required(true) !!}
            {!! BootForm::password('Password', 'password')->required(true) !!}
            {!! BootForm::text('Outgoing Mail', 'outgoing_host')->required(true) !!}
            {!! BootForm::text('Outgoing Port', 'outgoing_port')->defaultValue('587')->required(true) !!}
            {!! BootForm::text('Encryption', 'encryption')->defaultValue('tls')->required(true) !!}

            {!! BootForm::submit('Save')->class('btn btn-success') !!}

        {!! BootForm::close() !!}
    @endif

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