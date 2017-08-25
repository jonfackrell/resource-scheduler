@extends('layouts.admin')

@section('Create a printjob')
    Departments
@endsection

@section('content')

    {!! BootForm::open()->action(route('upload.file'))->post()->enctype('multipart/form-data') !!}
    

      {!! BootForm::file('File', 'filename')->required() !!}
      
      {!! BootForm::submit('Submit') !!}
    {!! BootForm::close() !!}

    

@endsection