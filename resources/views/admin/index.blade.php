@extends('layouts.admin')

@section('title')
    Print Jobs
@endsection

@section('content')

    @if($statuses->count() > 0)

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
                                {{ $row->owner->first_name or ''}}
                                {{ $row->owner->last_name  or '' }}
                                <br>
                                {{ $row->currentStatus->name or ''}} {{ $row->options->infill }}

                                <br>

                                <a href="/uploadfile/{{ $row->id }}/edit" class="btn btn-success btn-sm"></i>Edit</a>

                                <a href="/download/{{ $row->filename }}" class="btn btn-success btn-sm"></i>Download</a>

                                 {!! BootForm::open()->action(route('admin.update', $row->id ))->put() !!}
                                  {!! BootForm::select('Status', 'status')->options($statuses->pluck('name', 'id'))->select($row->status)->hideLabel()->addClass('status-update') !!}
                                {!! BootForm::close() !!}



                            </p>
                        @endforeach
                    </div>
                @endforeach

            </div>
        </div>

    @else

        <div class="alert alert-info">
            <p>
                You do not currently have any Statuses set up for your department to display. <a href="{{ route('status.index') }}" class="btn btn-warning btn-xs">Manage Statuses</a>
            </p>
        </div>

    @endif

@endsection

@push('custom-scripts')
    
    <script type="text/javascript">
        $(function(){

            $(document).on('change', '.status-update', function(){
                var $select = $(this);
                console.log('Selected');
                $select.closest('form').submit();
            });

        });
    </script>
    
@endpush