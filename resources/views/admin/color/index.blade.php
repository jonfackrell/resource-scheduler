@extends('layouts.admin')

@section('content')

    {!! BootForm::open()->action(route('color.index'))->post() !!}

    {!! BootForm::text('Name', 'name')->required() !!}
    {!! BootForm::submit('Submit') !!}
    {!! BootForm::close() !!}

    @foreach($colors as $color)

        <p>
            <a href="/admin/color/{{ $color->id }}/edit">{{ $color->name }}</a>
        </p>

    @endforeach

@endsection