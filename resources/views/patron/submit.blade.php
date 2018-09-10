@extends('layouts.public')

@section('title')
    Upload 3D Model File
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="progress">
                <div class="progress-bar progress-bar-danger" data-transitiongoal="66" style="width: 66%;" aria-valuenow="66"></div>
            </div>
        </div>
    </div>



    <div class="col-md-3 col-xs-12 widget widget_tally_box">

        <div class="x_panel">
            <div class="x_content">

                <div class="flex">
                    <ul class="list-inline count2 widget_profile_box">
                        <li>
                            <span>&nbsp;</span>
                        </li>
                        <li>
                            <img src="{{ $printer->image }}" alt="..." class="img-circle profile_img">
                        </li>
                        <li>
                            <span>&nbsp;</span>
                        </li>
                    </ul>
                </div>

                <h3 class="name">{!! $printer->name !!}</h3>
                <h4 class="name">{!! $printer->departmentOwner->name !!}</h4>

                <p>Estimated Start</p>
                <p style="font-weight: bolder;">{!! $printer->timeToPrint->diffForHumans() !!}</p>
                <br />

                <table class="table">
                    <tr>
                        <th>Cost</th>
                        <td style="text-align: right;">{{ money_format('%(#2n', $printer->netCostToPrint/100 ) }}</td>
                    </tr>
                    @if($printer->coupon > 0)
                        <tr>
                            <th>Coupon</th>
                            <td style="text-align: right;">- {{ money_format('%(#2n', $printer->coupon/100 ) }}</td>
                        </tr>
                    @endif
                    <tr>
                        <th>Tax</th>
                        <td style="text-align: right;">+ {{ money_format('%(#2n', $printer->tax/100 ) }}</td>
                    </tr>
                    <tr style="border-top: 2px solid #dedede; font-size: 1.2em;">
                        <th>Total Cost</th>
                        <td style="text-align: right;">${!! money_format('%(#2n', $printer->costToPrint/100) !!}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-9 col-xs-12">

        <div class="x_panel">
            @if(!request()->has('coupon'))
                <div class="x_content">
                    <div class="flex">
                        {!! BootForm::open()->action(route('submit'))->post() !!}
                            <div class="row">
                                <div class="col-md-9">
                                    {!! BootForm::text('Coupon Code', "coupon_code") !!}
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label" for="submit">&nbsp;</label>
                                    {!! BootForm::submit('Apply')->class('btn btn-block btn-success') !!}
                                </div>
                            </div>
                        {!! BootForm::close() !!}
                    </div>
                </div>
            @endif
            {!! BootForm::open()->action(route('submit'))->post()->enctype('multipart/form-data') !!}
            <label class="x_content">
                <div class="flex">
                    <table class="table table-striped">
                        <thead></thead>
                        <tbody>
                            <tr>
                                <th>
                                    Weight
                                </th>
                                <td style="font-size: 16px;">
                                    {{ session('weight', request()->get('weight')) }} grams
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Time
                                </th>
                                <td style="font-size: 16px;">
                                    {{ session('time', request()->get('time')) }} minutes
                                </td>
                            </tr>
                            <tr>
                                <th style="vertical-align: middle;">
                                    Filament
                                </th>
                                <td style="vertical-align: middle;">
                                    <div style="height: 20px; width: 20px; float: left;  background-color: #{{ $color->hex_code }}"></div>
                                    <div style="margin-left: 10px; display: inline-block; font-size: 16px;">{{ $filament->name }}</div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        {!! BootForm::select('Quality', "options[quality]")->options(['low' => 'High Speed', 'medium' => 'Standard', 'high' => 'High Detail'])->select('medium') !!}
                    </div>
                    <div class="col-md-4">
                        {!! BootForm::select('Print Support?', "options[support]")->options([false => 'No', true => 'Yes'])->select(false) !!}
                    </div>
                    <div class="col-md-4">
                        <div class="form-group has-feedback">
                            <label class="control-label" for="options[infill]">Infill</label>
                            <input type="text" class="form-control" name="options[infill]" id="options[infill]" value="20">
                            <span class="fa fa-percent form-control-feedback right" aria-hidden="true" style="top: 23px;right:13px;"></span>
                        </div>
                    </div>
                </div>
                <label class="flex">
                    {!! BootForm::file('3D Model File', 'filename')->required()->helpBlock('Please upload your model as a <a href="https://www.lulzbot.com/cura" target="_blank">Cura</a> project (.curaproject). You may also upload a .3mf or .stl, but none of the print settings will be saved in these formats.') !!}
                    @if(strlen($department->terms) > 0)
                        <div>
                            {!! $department->terms !!}
                        </div>
                        <div style="margin: 10px 0px 0px 0px;">
                            {!! BootForm::checkbox('<b>I agree</b>', 'accept_terms')->required()->inline() !!}
                        </div>
                    @endif

                    {!! BootForm::textarea('Note', "note")->style('height: 100px;') !!}

                    {!! BootForm::hidden('department')->value($printer->departmentOwner->id) !!}
                    {!! BootForm::hidden('filament')->value(session('filament', request()->get('filament'))) !!}
                    {!! BootForm::hidden('color')->value(session('color', request()->get('color'))) !!}
                    {!! BootForm::hidden('printer')->value(session('printer', request()->get('printer'))) !!}
                    {!! BootForm::hidden('weight')->value(session('weight', request()->get('weight'))) !!}
                    {!! BootForm::hidden('time')->value(session('time', request()->get('time'))) !!}
                    @if(request()->has('coupon'))
                        {!! BootForm::hidden('coupon')->value(request()->get('coupon')) !!}
                    @endif
                    <section>
                        <legend>Purpose</legend>
                        <label class="radio-inline">
                            {!! BootForm::radio('Academic', "purpose")->value('academic')->required() !!}
                        </label>
                        <label class="radio-inline">
                            {!! BootForm::radio('Personal', "purpose")->value('personal')->required() !!}
                        </label>
                    </section>
                    <br />
                    {!! BootForm::submit('Submit')->class('btn btn-block btn-success') !!}
                </div>
            </div>
            {!! BootForm::close() !!}
        </div>
    </div>








@endsection