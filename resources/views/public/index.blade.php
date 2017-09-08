@extends('layouts.public')

@section('title')
    3D Printing
@endsection

@section('content')
    <div class="col-xs-3">
        <!-- required for floating -->
        <!-- Nav tabs -->
        <ul class="nav nav-tabs tabs-left">
            <li class="active"><a href="#home" data-toggle="tab" aria-expanded="false">Home</a>
            </li>
            <li class=""><a href="#how-it-works" data-toggle="tab" aria-expanded="false">How it works</a>
            </li>
            <li class=""><a href="#tutorials" data-toggle="tab" aria-expanded="true">Tutorials</a>
            </li>
            <li><a href="#faq" data-toggle="tab">FAQ</a>
            </li>
        </ul>
    </div>
    <div class="col-xs-9">
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="home">
                <p class="lead">Home tab</p>
                <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher
                    synth. Cosby sweater eu banh mi, qui irure terr.</p>
            </div>
            <div class="tab-pane" id="how-it-works">Profile Tab.</div>
            <div class="tab-pane" id="tutorials">Messages Tab.</div>
            <div class="tab-pane" id="faq">
                @php
                $faqs = collect([
                    ['title' => 'Can the Mac Lab Staff design an idea I have?', 'body' => '...'],
                    ['title' => 'Can I print a gun or knife?', 'body' => '...'],
                    ['title' => 'Is 3D printing in the library for students and employees only?', 'body' => '...'],
                    ['title' => 'What happens if I can’t pay right away?', 'body' => '...'],
                    ['title' => 'Can I print something that’s not for a class assignment?', 'body' => '...'],
                    ['title' => 'Can I print copyrighted material?', 'body' => '...'],
                    ['title' => 'How long does an average print take?', 'body' => '...'],
                    ['title' => 'If I buy my own filament, can it be used to print?', 'body' => '...'],
                    ['title' => 'How will I know when my print is done?', 'body' => '...'],
                    ['title' => 'Can I cancel a print after it’s been submitted?', 'body' => '...'],
                    ['title' => 'If I cancel a print do I still have to pay for it?', 'body' => '...'],
                    ['title' => 'If I’m not satisfied with my print, can I get a refund?', 'body' => '...'],
                    ['title' => 'What happens after I upload my design?', 'body' => '...'],
                    ['title' => 'Can I have my 3D print shipped to me?', 'body' => '...'],
                    ['title' => 'Can someone else come and pick up my print for me (spouse, sibling, friend, group member, etc.)?', 'body' => '...']
                ]);
                @endphp
                <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                    @foreach($faqs as $key => $faq)
                        <div class="panel">
                            <a class="panel-heading" role="tab" id="{{ $key }}" data-toggle="collapse" data-parent="#accordion" href="#{{ $key }}" aria-expanded="true" aria-controls="collapseOne">
                                <h4 class="panel-title">{{ $faq['title'] }}</h4>
                            </a>
                            <div id="{{ $key }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="true" style="">
                                <div class="panel-body">
                                    {!! $faq['body'] !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection