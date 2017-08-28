@extends('layouts.admin')

@section('title')
    Choose a Printer
@endsection

@section('content')

    @foreach($printers as $key => $printer)
        <div class="col-md-3 col-xs-12 widget widget_tally_box">
            <div class="x_panel fixed_height_390">
                <div class="x_content">

                    <div class="flex">
                        <ul class="list-inline count2 widget_profile_box">
                            <li>
                                <span>&nbsp;</span>
                            </li>
                            <li>
                                <img src="https://www.lulzbot.com/sites/default/files/TAZ_6_Angle_Main_Product_Page.png" alt="..." class="img-circle profile_img">
                            </li>
                            <li>
                                <span>&nbsp;</span>
                            </li>
                        </ul>
                    </div>

                    <h3 class="name">{!! $printer->name !!}</h3>
                    <h4 class="name">{!! $printer->owningDepartment->name !!}</h4>

                    <div class="flex">
                        <ul class="list-inline count2">
                            <li style="text-align: center; width: 49%;">
                                <h3>{!! $printer->timeToPrint !!}</h3>
                                <span>Est. Start</span>
                            </li>
                            <li style="text-align: center; width: 49%;">
                                <h3>${!! money_format('%(#2n', $printer->costToPrint/100) !!}</h3>
                                <span>Cost</span>
                            </li>
                        </ul>
                    </div>
                    <p>
                        Start time is not guaranteed. We try our best to estimate how long it's going to take, but because of timing our open hours it can vary quite a bit.
                    </p>
                </div>
            </div>
        </div>
    @endforeach

@endsection
