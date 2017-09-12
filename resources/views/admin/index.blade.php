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
                                        {{ $row->getFilament->name or '' }}
                                    </td>
                                    <td>
                                        {!! BootForm::open()->action(route('admin.update', $row->id ))->put() !!}
                                        {!! BootForm::select('Status', 'status')->options($statuses->pluck('name', 'id'))->select($row->status)->hideLabel()->addClass('status-update') !!}
                                        {!! BootForm::close() !!}
                                    </td>
                                    <td>
                                        <a href="/uploadfile/{{ $row->id }}/edit" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>Edit</a>
                                        <a href="/download/{{ $row->filename }}" class="btn btn-success btn-xs" title="{{ $row->original_filename }}"></i>Download</a>
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