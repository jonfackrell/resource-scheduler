@extends('layouts.public')

@section('title')
    Tell us a little about your model
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="progress">
                <div class="progress-bar progress-bar-danger" data-transitiongoal="0" style="width: 0%;" aria-valuenow="0"></div>
            </div>
        </div>
    </div>

    {!! BootForm::open()->action(route('choose-printer'))->get() !!}
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        {!! BootForm::text('Estimated Time', 'hours')->placeHolder('Hours')->required() !!}
                    </div>
                    <div class="col-md-6">
                        {!! BootForm::text('&nbsp;', 'minutes')->placeHolder('Minutes')->required() !!}
                    </div>
                    <div class="col-md-6">
                        {!! BootForm::text('Weight (in grams)', 'weight')->required() !!}
                        {!! BootForm::submit('Submit')->class('btn btn-primary') !!}
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-md-offset-1 alert alert-info">
                <h2>
                    <i class="fa fa-lightbulb-o pull-right" aria-hidden="true"></i>
                    Tip
                </h2>
                <hr />
                <p>
                    Start by telling us a little about your 3D Model. We use this information to show you which filaments are available, how much it's going to cost, and estimate when it will be printed.
                </p>
                <p>You can find this information in the upper left-hand corner of the Cura workspace:</p>
                <p>
                    <img src="https://content.byui.edu/file/d6a05741-b7ed-43f2-a33a-42c227995b72/1/cura-pre-print-info.png" alt="" style="width: 100%; height: auto;"/>
                </p>
            </div>
        </div>

    {!! BootForm::close() !!}

@endsection