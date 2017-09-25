@extends('layouts.admin')

@section('title')
	Printer
@endsection

@section('content')

	@if(auth()->guard('web')->user()->isSuperUser() || auth()->guard('web')->user()->can('create-printers'))
		{!! BootForm::open()->action(route('printer.index'))->post() !!}
			{!! BootForm::text('Name', 'name') !!}
			{!! BootForm::textarea('Description', 'description')->addClass('summernote') !!}
			{!! BootForm::text('Image URL', 'image') !!}
			{!! BootForm::text('Flat Printing Fee', 'flat_fee') !!}
			{!! BootForm::text('Per Hour Fee', 'per_hour') !!}
			{!! BootForm::text('Overtime Fee', 'overtime_fee') !!}
			{!! BootForm::text('Start Charging Overtime At', 'overtime_start') !!}
		  	{!! BootForm::submit('Submit') !!}
		{!! BootForm::close() !!}
	@endif

	@if($printers->count() > 0)
		<table class="table table-striped sorted_table">
			<thead>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</thead>
			<tbody>
			@foreach($printers as $printer)
				<tr data-id="{{ $printer->id }}">
					<th>
						<a href="/admin/printer/{{ $printer->id }}/edit">{{ $printer->name }}</a>
					</th>
					<td>

					</td>
					<td>

					</td>
					<td>
						{!! BootForm::open()->action(route('printer.destroy', $printer->id))->delete() !!}
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
				You currently do not have any Printers setup in your system.
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
                        url: '{{ route('printer.sort') }}',
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