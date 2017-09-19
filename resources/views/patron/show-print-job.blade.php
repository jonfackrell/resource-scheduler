@extends('layouts.public')

@section('title')
    3D Print
@endsection

@section('content')
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
                                {{ $printJob->weight }} grams
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Time
                            </th>
                            <td style="font-size: 16px;">
                                {{ $printJob->time }} minutes
                            </td>
                        </tr>
                        <tr>
                            <th style="vertical-align: middle;">
                                Filament
                            </th>
                            <td style="vertical-align: middle;">
                                <div style="height: 20px; width: 20px; float: left;  background-color: #{{ $printJob->getColor->hex_code }}"></div>
                                <div style="margin-left: 10px; display: inline-block; font-size: 16px;">{{ $filament->name }}</div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Status
                            </th>
                            <td>
                                {{ $printJob->currentStatus->name }}
                            </td>
                        </tr>
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
                <div class="flex">

                </div>
            </div>
        </div>
    </div>
@endsection