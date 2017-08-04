@extends('layouts.admin')

@section('title')
    Print Jobs
@endsection

@section('content')

    <ul class="list-unstyled msg_list">

        @foreach($printJobs as $key => $printJob)
            <li style="width: 100% !important;" data-id="{{ $printJob->id }}">
                <div class="row" style="width: 100% !important;">
                    <div class="col-md-8">
                        <a>
                            <span class="image">
                              <button type="button" class="btn btn-success btn-xs">{{ $printJob->currentStatus->name or '' }}</button>
                            </span>
                            <span>
                                <span>{{ $printJob->owner->first_name  or '' }} {{ $printJob->owner->last_name  or '' }} </span>
                                <span class="time">3 mins ago</span>
                            </span>
                            <!--
                            <span class="message">
                              Film festivals used to be do-or-die moments for movie makers. They were where you met the producers that
                            </span>
                            -->
                        </a>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-success btn-xs">Paid</button>
                    </div>
                </div>
            </li>
        @endforeach

    </ul>



@endsection