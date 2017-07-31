@extends('layouts.admin')

@section('content')

	{!! BootForm::open()->action('admin/user')->post() !!}
	  {!! BootForm::text('First Name', 'first_name') !!}
  	  {!! BootForm::text('Last Name', 'last_name') !!}
      
      {!! BootForm::email('Email', 'email') !!}
      {!! BootForm::password('Password', 'password') !!}
      {!! BootForm::text('Department', 'department') !!}
      {!! BootForm::submit('Submit') !!}
	{!! BootForm::close() !!} 

	@foreach($users as $user)

        <p>
            <a href="/admin/user/{{ $user->id }}/edit">{{ $user->name }}</a>
        </p>

    @endforeach

@endsection