@extends('layouts.public')

@section('title')
    3D Printers
@endsection

@section('content')

    @foreach($printers as $printer)
        <div class="row">
            <div class="col-md-3">
                <p>
                    <img src="{{ $printer->image }}" alt="" style="width: 100%; height: auto; max-width: 400px;"/>
                </p>
                <br />
                <div class="tile" style="text-align: center;">
                    <span>Estimated Start</span>
                    <h2>{!! $printer->timeToPrint()->diffForHumans() !!}</h2>
                </div>
            </div>
            <div class="col-md-6">
                <h2>{{ $printer->name }} <small>{{ $printer->departmentOwner->name }}</small></h2>
                {!! $printer->description !!}
                <div class="row">
                    @foreach($printer->filaments as $filament)
                        @if($filament->colors($printer->departmentOwner->id)->count() > 0)
                            <div class="col-md-12" style="padding-left: 24px;">
                                <h3><small>{{ $filament->name }}</small></h3>
                                <p>{!! $filament->description !!}</p>
                                <div>
                                    <div style="font-weight: bolder; display: inline-block; vertical-align: top; padding-top: 1px; padding-left: 18px;">Filament Colors: </div>
                                    @foreach($filament->colors($printer->departmentOwner->id) as $color)
                                        <div style="height: 20px; width: 20px; display: inline-block; background-color: #{{ $color->hex_code }}" title="{{ $color->name }}"></div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        @if(!$loop->last)
        <hr />
        @endif
    @endforeach

@endsection