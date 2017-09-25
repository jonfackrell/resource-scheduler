@extends('layouts.admin')

@section('title')
	Notifications
@endsection

@section('content')
    @if(auth()->guard('web')->user()->isSuperUser() || auth()->guard('web')->user()->can('create-notifications'))
        {!! BootForm::open()->action(route('notification.index'))->post() !!}
            <div class="row">
                <div class="col-md-6">
                    {!! BootForm::text('Display Name', 'display_name')->required() !!}
                    {!! BootForm::text('Subject', 'subject')->required() !!}
                    {!! BootForm::textarea('Message', 'message')->addClass('summernote')->required() !!}
                </div>
            </div>

            {!! BootForm::submit('Submit')->class('btn btn-success') !!}
        {!! BootForm::close() !!}
    @endif
    @if($notifications->count() > 0)
        <table class="table table-striped sorted_table">
            <thead>
                <tr>
                    <th></th>
                    <th>Display Name</th>
                    <th>Subject</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($notifications as $notification)
                <tr data-id="{{ $notification->id }}">
                    <th>
                        <a href="/admin/notification/{{ $notification->id }}/edit">{{ $notification->display_name }}</a>
                    </th>
                    <td>
                        <a href="/admin/notification/{{ $notification->id }}/edit">{{ $notification->subject }}</a>
                    </td>
                    <td>
                        {!! BootForm::open()->action(route('notification.destroy', $notification->id))->delete() !!}
                        {!! BootForm::submit('Delete', 'delete')->class('btn btn-danger btn-xs delete') !!}
                        {!! BootForm::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot></tfoot>
        </table>
    @else
        <div class="alert alert-danger" style="margin-top: 10px;">
            <p>
                You currently do not have any Notifications setup in your system.
            </p>
        </div>
    @endif

@endsection

@push('styles')
	<link rel="stylesheet" href="/css/jquery-sortable.css" />
    <link rel="stylesheet" href="/css/summernote.css" />
    <style>
        .note-group-select-from-files{display: none;}
    </style>
@endpush

@push('custom-scripts')
	<script src="/js/jquery-sortable.min.js"></script>
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

            var $table = $('.sorted_table').sortable({
                containerSelector: 'table',
                itemPath: '> tbody',
                itemSelector: 'tr',
                delay: 100,
                placeholder: '<tr class="placeholder"/>',
                onDrop: function  ($item, container, _super) {
                    var data = $table.sortable("serialize").get();

                    var jsonString = JSON.stringify(data, null, ' ');

                    _super($item, container);
                    $.ajax({
                        type: "POST",
                        url: '{{ route('notification.sort') }}',
                        data: {'order': jsonString},
                        dataType: "json",
                        success: function (data) {

                        },
                        error: function (data) {

                        }
                    });
                }
            });
		});

	</script>
@endpush