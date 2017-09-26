@extends('layouts.admin')

@section('title')
	Printer
@endsection

@section('content')

	@if(auth()->guard('web')->user()->isSuperUser() || auth()->guard('web')->user()->can('create-printers'))
		{!! BootForm::open()->action(route('printer.index'))->post() !!}
			{!! BootForm::text('Name', 'name')->required() !!}
			{!! BootForm::textarea('Description', 'description')->addClass('summernote')->required() !!}
			{!! BootForm::text('Image URL', 'image')->required() !!}
			{!! BootForm::text('Flat Printing Fee', 'flat_fee')->helpBlock('You can add a flat printing fee to use this printer. Value should be in cents.') !!}
			{!! BootForm::text('Per Hour Fee', 'per_hour')->helpBlock('You can charge a per hour fee to use this printer. Value should be in cents.') !!}
			{!! BootForm::text('Overtime Fee', 'overtime_fee')->helpBlock('Alternatively, you can charge a fee for every X hours. For example, add $1 for every 12 hours of printing. Value should be in cents.') !!}
			{!! BootForm::text('Start Charging Overtime At', 'overtime_start')->helpBlock('If charging an overtime fee, specficy the interval for when the fee should be applied. Value should be in minutes.') !!}
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