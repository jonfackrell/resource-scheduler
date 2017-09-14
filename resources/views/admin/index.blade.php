@extends('layouts.admin')

@section('title')
    Print Jobs
@endsection

@section('content')

    @if($statuses->count() > 0)

        <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="status-tabs" class="nav nav-tabs bar_tabs" role="tablist">
                @foreach($statuses as $status)
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
                                <th style="width: 20%">Project Name</th>
                                <th>Printer</th>
                                <th>Filament</th>
                                <th>Status</th>
                                <th style="width: 20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($printJob as $row)
                                <tr data-id="{{ $row->id }}">
                                    <td>
                                        {{ $row->owner->first_name or ''}}
                                        {{ $row->owner->last_name  or '' }}
                                        <br>
                                        <small>{{ $row->created_at->toDayDateTimeString() }}</small>
                                    </td>
                                    <td>
                                        {{ $row->selectedPrinter->name }}
                                    </td>
                                    <td>
                                        <span style="font-weight: bold;margin-right: 6px;">Name: </span>{{ $row->getFilament->name or '' }}
                                        <br />
                                        <span style="font-weight: bold;margin-right: 6px;">Color: </span>
                                        <div style="height: 20px; width: 20px; margin-right: 6px; margin-bottom: -5px; display: inline-block;  background-color: #{{ $row->getcolor->hex_code }}" ></div>
                                        {{ $row->getcolor->name or '' }}
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