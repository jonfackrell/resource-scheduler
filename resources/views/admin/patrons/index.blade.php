@extends('layouts.admin')

@section('title')
    Patrons
@endsection

@section('content')    

    @if($patrons->count() > 0)
        <table class="table table-striped sorted_table">
            <thead>
                <tr>
                    <td></td>
                    <td>Email</td>
                    <td>Created</td>
                    <td>Updated</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
            @foreach($patrons as $patron)
                <tr data-id="{{ $patron->id }}">
                    <th>
                        @if($patron->banned == 1)
                            <i class="fa fa-exclamation-triangle" aria-hidden="true" style="color: red;" title="{{ strip_tags($patron->banned_reason) }}"></i>
                        @endif
                        <a href="/admin/patron/{{ $patron->id }}/edit">{{ $patron->first_name }} {{ $patron->last_name }}</a>
                    </th>
                    <td>
                        {{ $patron->email }}
                    </td>
                    <td>
                        {{ $patron->created_at->toDayDateTimeString() }}
                    </td>
                    <td>
                        {{ $patron->updated_at->toDayDateTimeString() }}
                    </td>
                    <td>
                        @if(auth()->guard('web')->user()->isSuperUser())
                            {!! BootForm::open()->action(route('admin.patron.destroy', $patron->id))->delete() !!}
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
                You currently do not have any Patrons using in your system.
            </p>
        </div>
    @endif

@endsection
