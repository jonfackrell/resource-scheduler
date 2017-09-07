@extends('layouts.public')

@section('title')
    History
@endsection

@section('content')

    <table class="table table-striped projects">
        <thead>
        <tr>
            <th style="width: 20%">Project Name</th>
            <th>Status</th>
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
                        <button type="button" class="btn btn-info btn-sm">{{ $printJob->currentStatus->name or '' }}</button>
                    </td>
                    <td>
                        $ {{ money_format('%i', $printJob->cost) }}
                    </td>
                    <td>
                        <button type="button" class="btn @if($printJob->paid == true) btn-success @else btn-warning @endif btn-sm">@if($printJob->paid == true) Payment Received @else Payment Pending @endif</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            {!! $printJobs->links() !!}
        </tfoot>
    </table>
	

@endsection
