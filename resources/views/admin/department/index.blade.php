@extends('layouts.admin')

@section('content')

    {!! BootForm::open()->action('admin/department')->post() !!}
      {!! BootForm::text('Name', 'name') !!}
      {!! BootForm::textarea('Description', 'description') !!}
      
    {!! BootForm::close() !!}

    @foreach($departments as $department)

        <p>
            <a href="/admin/department/{{ $department->id }}/edit">{{ $department->name }}</a>
        </p>

    @endforeach

@endsection