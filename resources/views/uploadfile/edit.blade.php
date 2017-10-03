@extends('layouts.admin')

@section('title')
    Edit Print Job
@endsection

@section('content')

    {!! BootForm::open()->action(route('uploadfile.update', $printjob))->put()->enctype('multipart/form-data') !!}
        <div class="row">
            <div class="col-md-6">
                <h2>{{ $patron->first_name . ' ' . $patron->last_name}}</h2>
                <a href="mailto:{{ $patron->email }}"><i class="fa fa-envelope"></i> {{ $patron->email }}</a>
            </div>
            <div class="col-md-6">
                @if(auth()->guard('web')->user()->isSuperUser() || auth()->guard('web')->user()->can('update-pricing'))
                    {!! BootForm::select('Pricing options', "pricing_option")->options(['full' => 'Full Price', 'cost' => 'Cost Only', 'free' => 'Free'])->select($printjob->pricing_option) !!}
                @endif
            </div>
        </div>

        <br />
        <br />
        {!! BootForm::bind($printjob) !!}
        {!! BootForm::select('Department', 'department')->options($departments) !!}
        <div class="row">
            <div class="col-md-6">
                {!! BootForm::text('Estimated Time', 'hours')->placeHolder('Hours')->required()->value(floor($printjob->time / 60)) !!}
            </div>
            <div class="col-md-6">
                {!! BootForm::text('&nbsp;', 'minutes')->placeHolder('Minutes')->required()->value($printjob->time % 60) !!}
            </div>
        </div>
        {!! BootForm::file('File', 'filename') !!}
        <div class="row">
            <div class="col-md-4">
                {!! BootForm::select('Quality', "options[quality]")->options(['low' => 'High Speed', 'medium' => 'Standard', 'high' => 'High Detail'])->select($printjob->options->quality) !!}
            </div>
            <div class="col-md-4">
                {!! BootForm::select('Print Support?', "options[support]")->options([false => 'No', true => 'Yes'])->select($printjob->options->support ) !!}
            </div>
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label" for="options[infill]">Infill</label>
                    <input type="text" class="form-control" name="options[infill]" id="options[infill]" value="{{ $printjob->options->infill }}">
                    <span class="fa fa-percent form-control-feedback right" aria-hidden="true" style="top: 23px;right:13px;"></span>
                </div>
            </div>
        </div>
        {!! BootForm::submit('Submit')->class('btn btn-success') !!}
    {!! BootForm::close() !!}
@endsection