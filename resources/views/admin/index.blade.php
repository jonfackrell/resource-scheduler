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

                <table class="table table-striped projects">

                <thead>
                <tr>
                    <th style="width: 20%">Project Name</th>
                    <th>Filament</th>
                    <th>Status</th>
                    <th style="width: 20%">Actions</th>
                </tr>
            </thead>
                    @foreach($printJob as $row)

                    

                    <tbody>
                        <tr data-id="{{ $row->id }}">
                            <td>
                                {{ $row->owner->first_name or ''}}
                                {{ $row->owner->last_name  or '' }} 
                            <br>
                            <small>{{ $row->created_at->toDayDateTimeString() }}</small>
                            </td>

                            <td>
                            {{ $row->getFilament->name or 'bust' }}
                            </td>

                            <td>

                             {!! BootForm::open()->action(route('admin.update', $row->id ))->put() !!}                              
                              {!! BootForm::select('Status', 'status')->options($statuses->pluck('name', 'id'))->select($row->status)->hideLabel()->addClass('status-update') !!}                              
                            {!! BootForm::close() !!} 
                            </td>

                            <td>
                            <a href="/uploadfile/{{ $row->id }}/edit" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i>Edit</a>
                            

                            <a href="/download/{{ $row->filename }}" class="btn btn-success btn-sm"></i>Download</a>
                            </td>
                        </tr>
                    
                        
                    @endforeach
                    </tbody>

                    </table>
                </div>
            @endforeach

        </div>
    </div>



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