@extends('layouts.public')

@section('title')
    Choose a Filament & Printer
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="progress">
                <div class="progress-bar progress-bar-danger" data-transitiongoal="33" style="width: 33%;" aria-valuenow="33"></div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        {!! BootForm::open()->action(route('choose-printer'))->get() !!}
        {!! BootForm::select('Filament', 'filament')
                        ->options($filaments->pluck('name', 'id'))
                        ->select($filament->id)
                        ->helpBlock('This page will automatically reload if you select a new filament.')
         !!}
        {!! BootForm::hidden('weight')->value(session('weight', request()->get('weight'))) !!}
        {!! BootForm::hidden('time')->value(session('time', request()->get('time'))) !!}
        {!! BootForm::close() !!}
        <p class="alert alert-info">
            {!! $filament->description !!}
        </p>
    </div>

    @foreach($printers as $key => $printer)
        <div class="col-md-3 col-xs-12 widget widget_tally_box">
            {!! BootForm::open()->action(route('upload'))->get()->id('printer-selection-form') !!}
                <div class="x_panel ">
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
                            <tr style="font-size: 1.2em;">
                                <th>Total Cost</th>
                                <td style="text-align: right;">${!! money_format('%(#2n', $printer->costToPrint/100) !!}</td>
                            </tr>
                        </table>
                        <!--
                        <div class="flex">
                            <ul class="list-inline count2">
                                <li style="text-align: center; width: 49%;">
                                    <h3>{!! $printer->timeToPrint->diffForHumans() !!}</h3>
                                    <span>Est. Start</span>
                                </li>
                                <li style="text-align: center; width: 49%;">
                                    <h3>${!! money_format('%(#2n', ($printer->costToPrint/100)) !!}</h3>
                                    <span>Cost</span>
                                </li>
                            </ul>
                        </div>
                        -->
                        <div>
                            <p>Select a filament color from the following options:</p>
                            <div class="form-group">
                                @php
                                    $printer_filament = $printer->filaments->where('id', $filament->id)->first();
                                    //dd($printer_filament->colors($printer->departmentOwner));
                                @endphp
                                @foreach($printer_filament->colors($printer->departmentOwner->id) as $color)
                                    {!! BootForm::radio('<div style="height: 20px; width: 20px; display: inline-block;  background-color: #' . $color->hex_code . '" title="' . $color->name . '"></div>', 'color')->addClass('hidden-radio')->inline()->value($color->id) !!}
                                @endforeach
                            </div>
                            <div class="alert alert-danger" id="color-warning" style="display: none;">
                                Please select a filament color.
                            </div>
                        </div>
                        <p>
                            {!! BootForm::submit('Select')->class('btn btn-block btn-success') !!}
                        </p>
                    </div>
                </div>
                {!! BootForm::hidden('filament')->value(session('filament')) !!}
                {!! BootForm::hidden('weight')->value(session('weight', request()->get('weight'))) !!}
                {!! BootForm::hidden('time')->value(session('time', request()->get('time'))) !!}
                {!! BootForm::hidden('printer')->value($printer->id) !!}
            {!! BootForm::close() !!}
        </div>

    @endforeach

@endsection

@push('styles')
    <style>
        .radio-inline, .radio-inline+.radio-inline{padding: 0px; margin: 0px;}
        .hidden-radio{display: none;}
        .hidden-radio-selected{border: 2px solid blue;}
    </style>
@endpush

@push('scripts')
    <script>
        $(function(){
            $(document).on('change', '#filament', function(){
                var $select = $(this);
                $select.closest('form').submit();
            });

            $(document).on('change', 'input[type="radio"]', function(){
                var $radio = $(this);
                var $radios = $('input[name="'+$radio.attr('name')+'"]');
                $radios.each(function(i, val){
                    $(this).siblings().removeClass('hidden-radio-selected');
                });
                $radio.siblings('div').addClass('hidden-radio-selected');
            });

            $(document).on('submit', '#printer-selection-form', function(){
                var $form = $(this);
                if(!$form.find("input[name='color']:checked").val()){
                    $form.find('#color-warning').show();
                    return false;
                }else{
                    $form.find('#color-warning').hide();
                    return true;
                }
            });
        });
    </script>
@endpush
