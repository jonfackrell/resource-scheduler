@extends('layouts.admin')

@section('title')
	Filaments
@endsection

@section('content')

	@if(auth()->guard('web')->user()->isSuperUser() || auth()->guard('web')->user()->can('create-filaments'))
		{!! BootForm::open()->action(route('filament.index'))->post() !!}
		    {!! BootForm::text('Name', 'name') !!}
		    {!! BootForm::textarea('Description', 'description')->addClass('summernote') !!}
		    {!! BootForm::submit('Submit') !!}
		{!! BootForm::close() !!}
	@endif

	@if($filaments->count() > 0)
		<table class="table table-striped sorted_table">
			<thead>
				<tr>
					<th></th>

					@foreach($printers as $printer)
						<th>{{ $printer->name }}</th>
					@endforeach

					<th></th>
				</tr>
			</thead>
			<tbody>
			@foreach($filaments as $filament)
				<tr data-id="{{ $filament->id }}">
					<th>
						<a href="/admin/filament/{{ $filament->id }}/edit">{{ $filament->name }}</a>
					</th>

					@foreach($printers as $printer)
						<td>
							<label>
								<input type="checkbox" class="flat" value="{{ $printer->id }}" @if($printer->whereHas('filaments', function($query) use ($printer, $filament){
									$query->where('printer', $printer->id)->where('filament', $filament->id);
								})->get()->count() > 0) checked @endif />
							</label>
                            @if($printer->whereHas('filaments', function($query) use ($printer, $filament){
									$query->where('printer', $printer->id)->where('filament', $filament->id);
								})->get()->count() > 0)
                                <a href="{{ route('filament.color-manager', ['filamentid' => $filament->id, 'printerid' => $printer->id]) }}" class="btn btn-primary btn-xs colors" style="margin-top: 5px; margin-left: 10px;">Colors</a>
                                @if(auth()->guard('web')->user()->isSuperUser() || auth()->guard('web')->user()->can('create-filaments'))
                                    <a href="{{ route('filament.pricing-manager', ['filamentid' => $filament->id, 'printerid' => $printer->id]) }}" class="btn btn-primary btn-xs colors" style="margin-top: 5px; margin-left: 5px;">Pricing</a>
                                @endif
                            @endif
						</td>
					@endforeach

					<td>
						@if(auth()->guard('web')->user()->isSuperUser())
							{!! BootForm::open()->action(route('filament.destroy', $filament->id))->delete() !!}
							{!! BootForm::submit('Delete', 'delete')->class('btn btn-danger btn-xs delete') !!}
							{!! BootForm::close() !!}
						@endif
					</td>
				</tr>
			@endforeach
			</tbody>
			<tfoot></tfoot>
		</table>
	@else
		<div class="alert alert-danger" style="margin-top: 10px;">
			<p>
				You currently do not have any Filaments setup in your system.
			</p>
		</div>
	@endif

@endsection

@push('styles')
	<link rel="stylesheet" href="/3d/css/jquery-sortable.css" />
	<link rel="stylesheet" href="/3d/css/summernote.css" />
	<style>
		.note-group-select-from-files{display: none;}
	</style>
@endpush

@push('custom-scripts')
	<script src="/3d/js/jquery-sortable.min.js"></script>
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

            $('input.flat').on('ifChecked', function(event){
                var $checkbox = $(this);
                var filamentid = $checkbox.closest('tr').data('id');
                var printerid = $checkbox.val();
                $.ajax({
                    type: "POST",
                    url: '/admin/filament/' + filamentid + '/toggle-printer',
                    data: {'action': true, 'printerid': printerid},
                    dataType: "json",
                    success: function (data) {

                    },
                    error: function (data) {

                    }
                });
                var $colors = $checkbox.parents('td').find('a.colors');
                $colors.show();
            });
            $('input.flat').on('ifUnchecked', function(event){
                var $checkbox = $(this);
                var filamentid = $checkbox.closest('tr').data('id');
                var printerid = $checkbox.val();
                $.ajax({
                    type: "POST",
                    url: '/admin/filament/' + filamentid + '/toggle-printer',
                    data: {'action': false, 'printerid': printerid},
                    dataType: "json",
                    success: function (data) {

                    },
                    error: function (data) {

                    }
                });
                var $colors = $checkbox.parents('td').find('a.colors');
                $colors.hide();
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
                        url: '{{ route('filament.sort') }}',
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