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
                <h2>3D Printing Home</h2>
                <hr />
                <p>

                </p>
                <div class="row">
                    <div class="col-md-12">
                        <h3><small>Getting Started</small></h3>
                        <hr />
                        <p>If you would like to get involved with 3D pringing, but don't have a 3D model of your own, there are several web sites online where you can download ready-to-print models for free. A few of our favorites are listed below.</p>
                    </div>
                    <div class="col-md-10 col-md-offset-1">
                        <h3><small>Thingiverse</small></h3>
                        <p>MakerBot's Thingiverse is a thriving design community for discovering, making, and sharing 3D printable things. As the world's largest 3D printing community, we believe that everyone should be encouraged to create and remix 3D things, no matter their technical expertise or previous experience. In the spirit of maintaining an open platform, all designs are encouraged to be licensed under a Creative Commons license, meaning that anyone can use or alter any design.</p>
                        <p>
                            <a href="https://www.thingiverse.com" target="_blank" class="btn btn-primary btn-sm">Go Now</a>
                        </p>
                    </div>
                    <div class="col-md-10 col-md-offset-1">
                        <h3><small>MyMiniFactory</small></h3>
                        <p>MyMiniFactory, which launched in 2013, is the world’s leading curated social platform for 3D printable objects. Think of us like the YouTube for 3D printing. On MyMiniFactory, you can find tens of thousands of 3D designs ready for you to download for free. These will work with any desktop 3D printer, and we have tested every single one so that it is guaranteed to print! Our mission statement is the following: Empowering creators to share digital objects with 3D printer owners around the world. MyMiniFactory's values center around quality and openness: quality with curation to assure all the models are printable, and openness with free downloads on all printable objects. </p>
                        <p>
                            <a href="https://www.myminifactory.com" target="_blank" class="btn btn-primary btn-sm">Go Now</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="how-it-works">
                <h2>How 3D Printing Works</h2>
                <hr />

            </div>
            <div class="tab-pane" id="tutorials">
                <h2>Tutorials</h2>
                <hr />
            </div>
            <div class="tab-pane" id="faq">
                <h2>Frequently Asked Questions</h2>
                <hr />
                @php
                $faqs = collect([
                    ['title' => 'Can the Mac Lab Staff design an idea I have?', 'body' => 'The Mac Lab Staff can guide and give advice, but will not create a 3D model for you from scratch.'],
                    ['title' => 'Can I print a gun or knife?', 'body' => 'No. In accordance with our 3D Printing Policy, the library reserves the right not to print weapons.'],
                    ['title' => 'Is 3D printing in the library for students and employees only?', 'body' => 'Yes. Only models provided by students and employees will be printed.'],
                    ['title' => 'What happens if I can’t pay right away?', 'body' => 'We will hold your printed model for 2 weeks before sending it to the accounting office as a fine which will create a hold on your BYU-Idaho account. After 2 weeks, the model will become property of the library, regardless of whether or not you pay the fine.'],
                    ['title' => 'Can I print something that’s not for a class assignment?', 'body' => 'Yes. However, class assignments may be given priority.'],
                    ['title' => 'How long does an average print take?', 'body' => 'It really depends on the design, size, and detail setting. Cura will provide a fairly accurate estimate for how long it will take your model to print.'],
                    ['title' => 'If I buy my own filament, can it be used to print?', 'body' => 'No, Unfortunately the Library can only print the filament that we have purchased.'],
                    ['title' => 'How will I know when my print is done?', 'body' => 'You should get an email when your print is done. You should pick it up as soon as possible, because we will only hold it for you for 2 weeks.'],
                    ['title' => 'Can I cancel a print after it’s been submitted?', 'body' => 'Yes, it is possible to cancel a print, but you should check your print history page to determine whether or not it is too late.'],
                    ['title' => 'If I cancel a print do I still have to pay for it?', 'body' => 'You can only cancel a print before it is sent to the printer. If you decide after it is being printed that you no longer want the print, you will still be required to pay for it.'],
                    ['title' => 'If I’m not satisfied with my print, can I get a refund?', 'body' => 'It depends. In most cases the answer is no. If there is a defect that is clearly the fault of the Mac Lab Staff or the 3D printer, you may request a refund from Br. Fackrell in MCK 120D.'],
                    ['title' => 'What happens after I upload my design?', 'body' => 'Once you upload your 3D model, a Mac Lab Employee will verify that it can be printed and email you to notify you of the outcome. Once it has been approved, your print will go into a queue to be printed. After it has been printed, you will receive another email that it\'s ready to pick up.'],
                    ['title' => 'Can I have my 3D print shipped to me?', 'body' => 'Unfortunately we cannot ship models at this time. You must come to campus to pick them up.'],
                    ['title' => 'Can someone else come and pick up my print for me (spouse, sibling, friend, group member, etc.)?', 'body' => 'Unfortunately you must pick up your own model at this time.'],
                    ['title' => 'Does it cost more to print in High Detail mode than in High Speed mode?', 'body' => 'Printing with high detail will cause your print to take longer to print. You will only be charged more if it takes longer than 12 hours to print.']
                ]);
                @endphp
                <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                    @foreach($faqs as $key => $faq)
                        <div class="panel">
                            <a class="panel-heading" role="tab" id="{{ $key }}" data-toggle="collapse" data-parent="#accordion" href="#{{ $key }}-content" aria-expanded="true" aria-controls="collapseOne">
                                <h4 class="panel-title">{{ $faq['title'] }}</h4>
                            </a>
                            <div id="{{ $key }}-content" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{{ $key }}" aria-expanded="true" style="">
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