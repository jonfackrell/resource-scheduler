@extends('layouts.admin')

@section('title')
    Print Jobs
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
                            <button type="button" class="btn btn-success btn-sm">{{ $printJob->currentStatus->name }}</button>
                        </td>
                        <td>
                            {{ $printJob->cost }}
                        </td>
                        <td>
                            <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-usd"></i>&nbsp; Mark Paid </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>




@endsection