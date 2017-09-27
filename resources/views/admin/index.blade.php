@extends('layouts.admin')

@section('title')
    Print Jobs
@endsection

@section('toolbox')

    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search" style="margin-bottom: 0px;">
        {!! BootForm::open()->action(route('admin'))->get() !!}
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

    @if($statuses->count() > 0)

        <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="status-tabs" class="nav nav-tabs bar_tabs" role="tablist">
                @foreach($dashboardStatuses as $status)
                    <li role="presentation" class="@if($loop->first) active @endif">
                        <a href="#tab_{{ $status->id }}" id="tab-{{ $status->id }}" role="tab" data-toggle="tab" aria-expanded="true">{{ $status->name }}</a>
                        <span id="status-count-{{ $status->id }}" class="badge bg-green" style="position: absolute; top: -10px; right: -5px; display: none;"></span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div id="status-tabs-content" class="tab-content">
            @foreach($printJobs as $key => $printJob)
                <div role="tabpanel" class="tab-pane fade @if($loop->first) active @endif in" id="tab_{{ $key }}" aria-labelledby="home-tab">
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th></th>
                                <th style="width: 20%">Patron Name</th>
                                <th>Printer</th>
                                <th>Options</th>
                                <th>Status</th>
                                <th style="max-width: 100px; ">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($printJob as $row)
                                <tr data-id="{{ $row->id }}">
                                    <td style="vertical-align: middle;">
                                        @if($row->paid == 1)
                                            <i class="fa fa-usd" aria-hidden="true" style="color: green; font-size: 2em;" title="Paid"></i>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $row->owner->first_name or ''}}
                                        {{ $row->owner->last_name  or '' }}
                                        <br />
                                        <span style="font-weight: bold;margin-right: 6px;">I#: </span>{{ $row->owner->inumber  or '' }}
                                        <br />
                                        <small>{{ $row->created_at->toDayDateTimeString() }}</small>
                                    </td>
                                    <td>
                                        {{ $row->selectedPrinter->name }}
                                        <br />
                                        {{ $row->time }} min
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <span style="font-weight: bold;margin-right: 6px;">Name: </span>{{ $row->getFilament->name or '' }}
                                                <br />
                                                <span style="font-weight: bold;margin-right: 6px;">Color: </span>
                                                <div style="height: 20px; width: 20px; margin-right: 6px; margin-bottom: -5px; display: inline-block;  background-color: #{{ $row->getcolor->hex_code }}" ></div>
                                                {{ $row->getcolor->name or '' }}
                                            </div>
                                            <div class="col-md-4">
                                                <span style="font-weight: bold;margin-right: 6px;">Amount: </span>{{ $row->weight }} grams
                                                <br />
                                                <span style="font-weight: bold;margin-right: 6px;">Infill: </span>
                                                @if(isset($row->options->infill) && $row->options->infill == true)
                                                    {{ $row->options->infill }}%
                                                @else
                                                    N/A
                                                @endif

                                            </div>
                                            <div class="col-md-4">
                                                <span style="font-weight: bold;margin-right: 6px;">Quality: </span>
                                                @if(isset($row->options->quality) && $row->options->quality == 'low')
                                                    High Speed
                                                @elseif(isset($row->options->quality) && $row->options->quality == 'medium')
                                                    Standard
                                                @elseif(isset($row->options->quality) && $row->options->quality == 'high')
                                                    High Detail
                                                @endif
                                                <br />
                                                <span style="font-weight: bold;margin-right: 6px;">Support: </span>
                                                @if(isset($row->options->support) && $row->options->support == true)
                                                    Yes
                                                @else
                                                    No
                                                @endif

                                            </div>
                                        </div>

                                    </td>
                                    <td>
                                        {!! BootForm::open()->action(route('admin.edit', $row->id ))->get() !!}
                                        {!! BootForm::select('Status', 'status')->options($statuses->pluck('name', 'id'))->select($row->status)->hideLabel()->addClass('status-update input-sm') !!}
                                        {!! BootForm::close() !!}
                                    </td>
                                    <td>
                                        <a href="{{ route('uploadfile.edit', $row->id) }}" class="btn btn-info btn-sm" title="Edit"><i class="fa fa-pencil"></i></a>
                                        <a href="{{ route('download', $row->filename) }}" class="btn btn-success btn-sm" title="Download {{ $row->original_filename }}"></i><i class="fa fa-download"></i></a>
                                        <a href="{{ route('admin.create-email', $row->id) }}" class="btn btn-warning btn-sm" title="Email"></i><i class="fa fa-envelope"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="4">
                                {!! $printJob->fragment(str_slug($key))->links() !!}
                            </td>
                        </tr>

                        </tfoot>

                    </table>
                </div>
            @endforeach
        </div>

    @else

        <div class="alert alert-info">
            <p>
                You do not currently have any Statuses set up for your department to display. <a href="{{ route('status.index') }}" class="btn btn-warning btn-xs">Manage Statuses</a>
            </p>
        </div>

    @endif

@endsection

@push('styles')

@endpush

@push('custom-scripts')
    
    <script type="text/javascript">
        $(function(){

            window.statuses = [];
            @foreach($printJobs as $key => $printJob)
                window.statuses.push({
                    'id': {{ $key }},
                    'count': {{  $printJob->total() }}
                });
            @endforeach

            $.each(window.statuses, function(i, val){
                $('#status-count-'+val.id).text(val.count).show();
            });

            var hash = window.location.hash.replace('#', '');
            $('#status-tabs a#tab-' + hash).tab('show');

            $(document).on('change', '.status-update', function(){
                var $select = $(this);
                console.log('Selected');
                $select.closest('form').submit();
            });

        });
    </script>
    
@endpush