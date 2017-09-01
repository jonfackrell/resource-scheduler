@extends('layouts.admin')

@section('title')
    Print Jobs Pending Payment
@endsection

@section('content')


        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th style="width: 20%">Project Name</th>
                    <th>Status</th>
                    <th>Cost</th>
                    <th style="width: 20%">#Edit</th>
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
                            <button type="button" class="btn btn-info btn-sm">{{ $printJob->currentStatus->name }}</button>
                        </td>
                        <td>
                            {{ $printJob->cost }}
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