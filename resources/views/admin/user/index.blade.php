@extends('layouts.admin')

@section('title')
    Users
@endsection

@section('content')

	{!! BootForm::open()->action(route('user.index'))->post() !!}
	  {!! BootForm::text('First Name', 'first_name') !!}
  	  {!! BootForm::text('Last Name', 'last_name') !!}
      {!! BootForm::email('Email', 'email') !!}
      {!! BootForm::select('Department', 'department')->options($departments) !!}
      {!! BootForm::submit('Submit') !!}
	{!! BootForm::close() !!} 

	@foreach($users as $user)

        <p>
            <a href="/admin/user/{{ $user->id }}/edit">{{ $user->first_name }} {{ $user->last_name }}</a>
        </p>

    @endforeach

@endsection