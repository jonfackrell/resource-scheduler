{!! BootForm::open()->action('admin/department')->post() !!}
  {!! BootForm::text('Type', 'first_name') !!}
  {!! BootForm::text('Cost', 'last_name') !!}
  {!! BootForm::date('Color', 'date_of_birth') !!}
  {!! BootForm::email('Email', 'email') !!}
  {!! BootForm::password('Password', 'password') !!}
  {!! BootForm::submit('Submit') !!}
{!! BootForm::close() !!} 