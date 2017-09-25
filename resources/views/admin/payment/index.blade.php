@extends('layouts.admin')

@section('title')
    Print Jobs Pending Payment
@endsection

@section('toolbox')

    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search" style="margin-bottom: 0px;">
        {!! BootForm::open()->action(route('payment.index'))->get() !!}
        <div class="input-group" style="margin-bottom: 0px;">
            <input type="text" name="q" class="form-control" placeholder="Search Last or First Name" value="{{ request()->get('q', '') }}">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
            </span>
        </div>
        {!! BootForm::close() !!}
    </div>

@endsection

@section('content')


        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th style="width: 20%">Patron Name</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>File</th>
                    <th>Cost</th>
                    <th style="width: 20%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($printJobs as $key => $printJob)
                    <tr data-id="{{ $printJob->id }}">
                        <td>
                            <a>{{ $printJob->owner->first_name  or '' }} {{ $printJob->owner->last_name  or '' }}</a>
                            <br>
                            <small>{{ $printJob->created_at->toDayDateTimeString() }}</small>
                        </td>
                        <td>
                            {{ $printJob->departmentOwner->name }}
                        </td>
                        <td>
                            <button type="button" class="btn @if($printJob->completed <> 1) btn-success @else btn-info @endif btn-sm">{{ $printJob->currentStatus->name }}</button>
                        </td>
                        <td>
                            {{ str_limit($printJob->original_filename, 25) }}
                        </td>
                        <td>
                            $ {{ money_format('%i', $printJob->cost) }}
                        </td>
                        <td>
                            <a href="#" class="btn @if($printJob->paid == true) btn-success @else btn-primary @endif btn-sm toggle-print-job-payment-status @if($printJob->paid == true) paid @endif"><i class="fa fa-usd"></i>&nbsp; Mark Paid </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">
                        {!! $printJobs->links() !!}
                    </td>
                </tr>
            </tfoot>
        </table>





@endsection


@push('styles')

@endpush


@push('custom-scripts')

    <script>
        $(function(){

            $(document).on('click', '.toggle-print-job-payment-status', function(event){
                var $button = $(this);
                $button.button('loading');
                var id = $button.parents('tr').data('id');
                if($button.hasClass('paid')){
                    togglePrintJobPaymentStatus(id, 0);
                }else{
                    togglePrintJobPaymentStatus(id, 1);
                }
            });

            function togglePrintJobPaymentStatus(id, paymentStatus){

                $.ajax({
                    url: "/update-payment-status",
                    type: "POST",
                    data: {'id': id, 'paid': paymentStatus},
                    success: function(data){
                        var $row = $('tr[data-id="' + id +'"]');
                        var $button = $row.find('.toggle-print-job-payment-status');
                        if(data.status == 1){
                            $button.addClass('paid');
                            $button.removeClass('btn-primary').addClass('btn-success');
                        }else{
                            $button.removeClass('paid');
                            $button.removeClass('btn-success').addClass('btn-primary');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown){

                    },
                   complete: function(){
                       var $row = $('tr[data-id="' + id +'"]');
                       var $button = $row.find('.toggle-print-job-payment-status');
                       $button.button('reset');
                   }
                });

            }
        });
    </script>
@endpush