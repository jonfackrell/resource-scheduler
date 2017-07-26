{!! BootForm::open()->action('admin/department')->post() !!}
  {!! BootForm::text('First Name', 'first_name') !!}
  {!! BootForm::text('Last Name', 'last_name') !!}
  {!! BootForm::date('Date of Birth', 'date_of_birth') !!}
  {!! BootForm::email('Email', 'email') !!}
  {!! BootForm::password('Password', 'password') !!}
  {!! BootForm::submit('Submit') !!}
{!! BootForm::close() !!}

@foreach($departments as $department)

	<p>
		<a href="/admin/department/{{ $department->id }}">{{ $department->name }}</a>
	</p>

@endforeach