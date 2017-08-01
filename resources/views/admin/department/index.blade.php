@extends('layouts.admin')

@section('content')

    {!! BootForm::open()->action(route('department.index'))->post() !!}

      {!! BootForm::text('Name', 'name')->required() !!}
      {!! BootForm::textarea('Description', 'description')->required() !!}
      {!! BootForm::submit('Submit') !!}
    {!! BootForm::close() !!}

    @foreach($departments as $department)

        <p>
            <a href="/admin/department/{{ $department->id }}/edit">{{ $department->name }}</a>
        </p>

    @endforeach

@endsection