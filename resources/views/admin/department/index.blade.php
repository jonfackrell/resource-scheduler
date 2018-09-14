@extends('layouts.admin')

@section('title')
    Departments
@endsection

@section('content')

    @if(auth()->guard('web')->user()->isSuperUser())
        {!! BootForm::open()->action(route('department.index'))->post() !!}
            {!! BootForm::text('Name', 'name')->required() !!}
            {!! BootForm::textarea('Description', 'description')->required()->addClass('summernote') !!}
            {!! BootForm::textarea('Terms', 'terms')->addClass('summernote') !!}
            {!! BootForm::textarea('Payment Instructions', 'payment_instructions')->addClass('summernote') !!}
            {!! BootForm::text('Tax Rate', 'tax_rate')->required()->helpBlock('For a 6% tax input 1.06. The cost to print will be multipled by the value entered here.') !!}
            {!! BootForm::submit('Submit') !!}
        {!! BootForm::close() !!}
    @endif

    @if($departments->count() > 0)
        <table class="table table-striped sorted_table">
            <thead>
            <tr>
                <td></td>
                <td>Created</td>
                <td>Updated</td>
                <td></td>
            </tr>
            </thead>
            <tbody>
            @foreach($departments as $department)
                <tr data-id="{{ $department->id }}">
                    <th>
                        <a href="/3d/admin/department/{{ $department->id }}/edit">{{ $department->name }}</a>
                    </th>
                    <td>
                        {{ $department->created_at->toDayDateTimeString() }}
                    </td>
                    <td>
                        {{ $department->updated_at->toDayDateTimeString() }}
                    </td>
                    <td>
                        @if(auth()->guard('web')->user()->isSuperUser())
                            {!! BootForm::open()->action(route('department.destroy', $department->id))->delete() !!}
                            {!! BootForm::submit('Delete', 'delete')->class('btn btn-danger btn-xs delete') !!}
                            {!! BootForm::close() !!}
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot></tfoot>
        </table>
    @else
        <div class="alert alert-danger" style="margin-top: 10px;">
            <p>
                You currently do not have any Departments setup in your system.
            </p>
        </div>
    @endif

@endsection


@push('styles')
    <link rel="stylesheet" href="/3d/css/summernote.css" />
    <style>
        .note-group-select-from-files{display: none;}
    </style>
@endpush

@push('custom-scripts')
    <script src="/3d/js/summernote.js"></script>
    <script>
        $(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.summernote').summernote({
                height: 200
            });

        });
    </script>
@endpush