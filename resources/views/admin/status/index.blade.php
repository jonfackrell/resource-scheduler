@extends('layouts.admin')

@section('title')
	Statuses
@endsection

@section('content')

	{!! BootForm::open()->action(route('status.index'))->post() !!}
        <div class="row">
            <div class="col-md-2">
                {!! BootForm::text('Name', 'name')->required() !!}
            </div>
            <div class="col-md-4">
                {!! BootForm::checkbox('Accept Payment', 'accept_payment')->helpBlock('Statuses with this option checked will allow users to pay for their prints.') !!}
                {!! BootForm::checkbox('Display in Dashboard', 'dashboard_display')->helpBlock('Statuses with this option checked will be added as a new tab to the admin dashboard.') !!}
            </div>
            <div class="col-md-4">
                {!! BootForm::checkbox('In Queue', 'in_queue')->helpBlock('Statuses with this option checked will be calculated in wait times.') !!}
                {!! BootForm::checkbox('Patrons Can Delete', 'can_delete')->helpBlock('Statuses with this option checked will let patrons delete their print jobs.') !!}
            </div>
        </div>

	    {!! BootForm::submit('Submit') !!}
	{!! BootForm::close() !!} 

    @if($statuses->count() > 0)
        <table class="table table-striped sorted_table">
            <thead>
                <tr>
                    <th></th>
                    <th>Display in Dashboard</th>
                    <th>Accept Payment</th>
                    <th>Subtract Inventory</th>
                    <th>In Queue</th>
                    <th>Completed</th>
                    <th>Patrons can Delete</th>
                    <th>Notification</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($statuses as $status)
                <tr data-id="{{ $status->id }}">
                    <th>
                        <a href="/admin/status/{{ $status->id }}/edit">{{ $status->name }}</a>
                    </th>
                    <td>
                        <label>
                            <input type="checkbox" class="flat" @if($status->dashboard_display == 1) checked  @endif data-field="dashboard_display"/>
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="checkbox" class="flat" @if($status->accept_payment == 1) checked  @endif data-field="accept_payment"/>
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="checkbox" class="flat" @if($status->subtract_inventory == 1) checked  @endif data-field="subtract_inventory"/>
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="checkbox" class="flat" @if($status->in_queue == 1) checked  @endif data-field="in_queue"/>
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="checkbox" class="flat" @if($status->completed == 1) checked  @endif data-field="completed"/>
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="checkbox" class="flat" @if($status->can_delete == 1) checked  @endif data-field="can_delete"/>
                        </label>
                    </td>
                    <td>
                        {!! BootForm::open() !!}
                        {!! BootForm::select('Notification', 'notification')
                                        ->options($notifications->pluck('display_name', 'id')->prepend(' - Choose - ', 0))
                                        ->select($status->notification)
                                        ->hideLabel()
                                        ->addClass('notification-update')
                                        ->data('field', 'notification')!!}
                        {!! BootForm::close() !!}
                    </td>
                    <td>
                        {!! BootForm::open()->action(route('status.destroy', $status->id))->delete() !!}
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
                You currently do not have any Statuses setup in your system.
            </p>
        </div>
    @endif

@endsection

@push('styles')
	<link rel="stylesheet" href="/css/jquery-sortable.css" />
@endpush

@push('custom-scripts')
	<script src="/js/jquery-sortable.min.js"></script>
	<script>
		$(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('input.flat').on('ifChecked', function(event){
                var $checkbox = $(this);
                var statusid = $checkbox.closest('tr').data('id');
                var field = $checkbox.data('field');
                var data = {};
                data[field] = 1;
                $.ajax({
                    type: "PUT",
                    url: '/admin/status/' + statusid,
                    data: data,
                    dataType: "json",
                    success: function (data) {

                    },
                    error: function (data) {

                    }
                });
            });
            $('input.flat').on('ifUnchecked', function(event){
                var $checkbox = $(this);
                var statusid = $checkbox.closest('tr').data('id');
                var field = $checkbox.data('field');
                var data = {};
                data[field] = 0;
                $.ajax({
                    type: "PUT",
                    url: '/admin/status/' + statusid,
                    data: data,
                    dataType: "json",
                    success: function (data) {

                    },
                    error: function (data) {

                    }
                });
            });

            $(document).on('change', '.notification-update', function(){
                var $select = $(this);
                var statusid = $select.closest('tr').data('id');
                var field = $select.data('field');
                var data = {};
                data[field] = $select.val();
                $.ajax({
                    type: "PUT",
                    url: '/admin/status/' + statusid,
                    data: data,
                    dataType: "json",
                    success: function (data) {

                    },
                    error: function (data) {

                    }
                });
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
                        url: '{{ route('status.sort') }}',
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