@extends('layouts.admin')

@section('title')
    Print Jobs
@endsection

@section('content')

    <div class="" role="tabpanel" data-example-id="togglable-tabs">
        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
            @foreach($statuses as $status)
                <li role="presentation" class="">
                    <a href="#tab_content{{ $status->id }}" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">{{ $status->name }}</a>
                </li>
            @endforeach


        </ul>
        <div id="myTabContent" class="tab-content">
            @foreach($printJobs as $key => $printJob)
                <div role="tabpanel" class="tab-pane fade @if($loop->first) active @endif in" id="tab_content{{ $key }}" aria-labelledby="home-tab">
                    @foreach($printJob as $row)
                        <p>
                            {{ $row->id }} {{ $row->currentStatus->name or ''}}
                        </p>
                    @endforeach
                </div>
            @endforeach

        </div>
    </div>



@endsection