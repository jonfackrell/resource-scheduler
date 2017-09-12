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

    {!! BootForm::open()->action(route('submit'))->post()->enctype('multipart/form-data') !!}

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
                    <tr>
                        <th>+ Tax</th>
                        <td style="text-align: right;">{{ money_format('%(#2n', $printer->tax/100 ) }}</td>
                    </tr>
                    <tr style="border-top: 2px solid #dedede; font-size: 1.2em;">
                        <th>Total Cost</th>
                        <td style="text-align: right;">${!! money_format('%(#2n', $printer->costToPrint/100) !!}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xs-12">

        <div class="x_panel">
            <div class="x_content">
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
                <div class="flex">
                    {!! BootForm::file('3D Model File', 'filename')->required()->helpBlock('Please upload your model as a <a href="https://www.lulzbot.com/cura" target="_blank">Cura</a> file (.amf)') !!}
                    <div>
                        {!! $department->terms !!}
                    </div>
                    {!! BootForm::hidden('department')->value($printer->departmentOwner->id) !!}
                    {!! BootForm::hidden('filament')->value(session('filament', request()->get('filament'))) !!}
                    {!! BootForm::hidden('color')->value(session('color', request()->get('color'))) !!}
                    {!! BootForm::hidden('printer')->value(session('printer', request()->get('printer'))) !!}
                    {!! BootForm::hidden('weight')->value(session('weight', request()->get('weight'))) !!}
                    {!! BootForm::hidden('time')->value(session('time', request()->get('time'))) !!}
                    <br />
                    <br />
                    {!! BootForm::submit('Submit')->class('btn btn-block btn-success') !!}
                </div>
            </div>
        </div>
    </div>





    {!! BootForm::close() !!}


@endsection