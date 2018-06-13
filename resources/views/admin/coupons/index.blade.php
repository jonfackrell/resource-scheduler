@extends('layouts.admin')

@section('title')
	Coupons
@endsection

@section('content')

	@if(auth()->guard('web')->user()->isSuperUser() || auth()->guard('web')->user()->can('update-pricing'))
		{!! BootForm::open()->action(route('coupons.store'))->post() !!}
            {!! BootForm::text('How many coupons would you like to create?', 'count')->defaultValue(10) !!}
		    {!! BootForm::text('Value', 'value')->helpBlock('Value whould be entered in cents. For example, a $5 coupon would be entered as 500.') !!}
            {!! BootForm::date('Expiration Date', 'expiration_at')
                            ->helpBlock('Coupons will no longer be valid after this date')
                            ->value(\Carbon\Carbon::now('America/Denver')->addMonths(3)->toDateString())
            !!}
		    {!! BootForm::submit('Submit') !!}
		{!! BootForm::close() !!}
	@endif

	@if($coupons->count() > 0)
		{!! $coupons->links() !!}
		<table class="table table-striped sorted_table">
			<thead>
				<tr>
					<th>Code</th>
					<th>Value</th>
					<th>Expiration Date</th>
					<th>Used Date</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			@foreach($coupons as $coupon)
				<tr data-id="{{ $coupon->id }}">
					<td>
						{{ $coupon->code }}
					</td>
                    <td>
                        ${{ ($coupon->value / 100) }}
                    </td>
                    <td>
						{{ $coupon->expiration_at->toDateString() }}
                    </td>
                    <td>
						{{ isset($coupon->used_at)?$coupon->used_at->toDateString():'' }}
                    </td>
					<td>
						@if(auth()->guard('web')->user()->isSuperUser() || auth()->guard('web')->user()->can('update-pricing'))
							{!! BootForm::open()->action(route('coupons.destroy', $coupon->id))->delete() !!}
							{!! BootForm::submit('Delete', 'delete')->class('btn btn-danger btn-xs delete') !!}
							{!! BootForm::close() !!}
						@endif
					</td>
				</tr>
			@endforeach
			</tbody>
			<tfoot>

			</tfoot>

		</table>
	@else
		<div class="alert alert-danger" style="margin-top: 10px;">
			<p>
				You currently do not have any Coupons setup in your system.
			</p>
		</div>
	@endif

@endsection

@push('styles')

	<style>

	</style>
@endpush

@push('custom-scripts')

	<script>
        $(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

		});
	</script>
@endpush