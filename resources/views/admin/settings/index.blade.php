@extends('layouts.admin')

@section('title')
    System Settings
@endsection

@section('content')

    @if(auth()->guard('web')->user()->isSuperUser())
        {!! BootForm::open()->action(route('settings.index'))->post() !!}
          {!! BootForm::text('Logo', 'LOGO')->defaultValue(((isset($settings->where('name', 'LOGO')->first()->value))?$settings->where('name', 'LOGO')->first()->value:'')) !!}
          {!! BootForm::textarea('Header HTML', 'HEADER_HTML')->addClass('summernote')->defaultValue(((isset($settings->where('name', 'HEADER_HTML')->first()->value))?$settings->where('name', 'HEADER_HTML')->first()->value:'')) !!}
          {!! BootForm::textarea('Custom CSS', 'HEADER_CSS')->addClass('summernote')->defaultValue(((isset($settings->where('name', 'HEADER_CSS')->first()->value))?$settings->where('name', 'HEADER_CSS')->first()->value:'')) !!}
          {!! BootForm::textarea('Footer HTML', 'FOOTER_HTML')->addClass('summernote')->defaultValue(((isset($settings->where('name', 'FOOTER_HTML')->first()->value))?$settings->where('name', 'FOOTER_HTML')->first()->value:'')) !!}
          {!! BootForm::textarea('Custom JavaScript', 'FOOTER_JS')->addClass('summernote')->defaultValue(((isset($settings->where('name', 'FOOTER_JS')->first()->value))?$settings->where('name', 'FOOTER_JS')->first()->value:'')) !!}
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