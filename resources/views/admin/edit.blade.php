@extends('layouts.admin')

@section('title')
    Updating Status & Sending Email
@endsection

@section('content')

    {!! BootForm::open()->action(route('admin.update', $printJob->id))->put() !!}
    {!! BootForm::text('Subject', 'subject')->value($status->systemNotification->subject) !!}
    {!! BootForm::textarea('Message', 'message')->addClass('summernote')->value($status->systemNotification->message) !!}
    {!! BootForm::hidden('new_status')->value($newStatus) !!}
    <button type="submit" name="action" value="send" class="btn btn-primary">Save & Send</button>
    <button type="submit" name="action" value="save" class="btn btn-default">Save Only</button>
    {!! BootForm::close() !!}

@endsection

@push('styles')
    <link rel="stylesheet" href="/3d/css/summernote.css" />
    <style>
        .note-group-select-from-files{display: none;}
    </style>
@endpush

@push('custom-scripts')
    <script src="/3d/js/summernote.js"></script>
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