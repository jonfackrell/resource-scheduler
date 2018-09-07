@extends('layouts.admin')

@section('title')
    Edit Print Job
@endsection

@section('content')
    <div style="float: right;">
        <div style="margin-top: 25px;">
            {!! BootForm::open()->action(route('admin.reprint', $printjob))->post() !!}
            {!! BootForm::submit('Reprint')->class('btn btn-info') !!}
            {!! BootForm::close() !!}
        </div>
    </div>
    {!! BootForm::open()->action(route('uploadfile.update', $printjob))->put()->enctype('multipart/form-data') !!}
        <div class="row">
            <div class="col-md-5">
                <h2>{{ $patron->first_name . ' ' . $patron->last_name}}</h2>
                <a href="mailto:{{ $patron->email }}"><i class="fa fa-envelope"></i> {{ $patron->email }}</a>
            </div>
            <div class="col-md-5">
                <div class="col-md-6 tile">
                    <label class="control-label" for="cost">Cost</label>
                    <h2 id="cost">${!! money_format('%(#2n', $printjob->total_cost) !!}</h2>
                </div>
                <div class="col-md-6">
                    @if(auth()->guard('web')->user()->isSuperUser() || auth()->guard('web')->user()->can('update-pricing'))
                        {!! BootForm::select('Pricing options', "pricing_option")->options(['full' => 'Full Price', 'cost' => 'Cost Only', 'free' => 'Free'])->select($printjob->pricing_option) !!}
                    @endif
                </div>
            </div>

        </div>

        <br />
        <br />
        {!! BootForm::bind($printjob) !!}
        {!! BootForm::select('Department', 'department')->options($departments) !!}
        <div class="row">
            <div class="col-md-4">
                {!! BootForm::text('Weight (grams)', 'weight')->placeHolder('Weight in grams')->required()->value($printjob->weight) !!}
            </div>
            <div class="col-md-4">
                {!! BootForm::text('Estimated Time', 'hours')->placeHolder('Hours')->required()->value(floor($printjob->time / 60)) !!}
            </div>
            <div class="col-md-4">
                {!! BootForm::text('&nbsp;', 'minutes')->placeHolder('Minutes')->required()->value($printjob->time % 60) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! BootForm::select('Filament', 'filament')
                        ->options($filaments)
                        ->select($printjob->filament)
                !!}
            </div>
            <div class="col-md-6">
                {!! BootForm::select('Color', 'color')
                        ->options($colors)
                        ->select($printjob->color)
                !!}
            </div>
        </div>
        {!! BootForm::file('File', 'filename') !!}
        <div class="row">
            <div class="col-md-4">
                {!! BootForm::select('Quality', "options[quality]")->options(['low' => 'High Speed', 'medium' => 'Standard', 'high' => 'High Detail'])->select((isset($printjob->options->quality))?$printjob->options->quality:null) !!}
            </div>
            <div class="col-md-4">
                {!! BootForm::select('Print Support?', "options[support]")->options([false => 'No', true => 'Yes'])->select((isset($printjob->options->support))?$printjob->options->support:null ) !!}
            </div>
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label" for="options[infill]">Infill</label>
                    <input type="text" class="form-control" name="options[infill]" id="options[infill]" value="{{ (isset($printjob->options->infill)?$printjob->options->infill:null) }}">
                    <span class="fa fa-percent form-control-feedback right" aria-hidden="true" style="top: 23px;right:13px;"></span>
                </div>
            </div>
        </div>
        {!! BootForm::submit('Submit')->class('btn btn-success') !!}
    {!! BootForm::close() !!}

    {!! BootForm::open()->action(route('uploadfile.destroy', $printjob))->delete() !!}
        {!! BootForm::submit('Delete')->class('btn btn-danger pull-right')->style('margin-top: -38px;') !!}
    {!! BootForm::close() !!}
    <hr />
    <div class="row">
        <div class="col-md-8">

            <h4>Recent Activity</h4>

            <!-- end of user messages -->
            <ul class="messages">
                @foreach($printjob->messages as $message)
                    <li>
                        @if($message->source == 'EMPLOYEE')
                            <img src="/img/themaclab_logo.png" class="avatar" alt="Employee">
                            @php
                                $author_name = $message->employee->first_name . ' ' . $message->employee->last_name;
                            @endphp
                        @else
                            <img src="/img/graduate-student-avatar.png" class="avatar" alt="Patron">
                            @php
                                $author_name = $message->patron->first_name . ' ' . $message->patron->last_name;
                            @endphp
                        @endif
                        <div class="message_date">
                            <h3 class="date text-info">{{ $message->created_at->day }}</h3>
                            <p class="month">{{ $message->created_at->format('M') }}</p>
                        </div>
                        <div class="message_wrapper">
                            <h4 class="heading">{{ $author_name }}</h4>
                            <p class="url">
                                <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
                                <a href="#">{{ $message->subject }}</a>
                            </p>
                            <blockquote class="message">
                                @if($message->source == 'EMPLOYEE')
                                    {!! $message->message !!}
                                @else
                                    {{ strip_tags($message->message) }}
                                @endif
                            </blockquote>
                        </div>
                    </li>
                @endforeach
            </ul>
            <!-- end of user messages -->
        </div>
        <div class="col-md-4">
            <h4>Files</h4>
            <ul class="to_do">
                @foreach($printjob->files as $file)
                    <li>
                        <p>
                            <span style="float: right;">{{ $file->created_at->tz('America/Denver')->toDayDateTimeString() }}</span>
                            <a href="{{ route('download', $file->filename) }}">{{ $file->original_filename }}</a>
                        </p>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection