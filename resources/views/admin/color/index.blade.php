@extends('layouts.admin')

@section('content')

    @if(auth()->guard('web')->user()->isSuperUser() || auth()->guard('web')->user()->can('create-colors'))
        {!! BootForm::open()->action(route('color.index'))->post() !!}
        {!! BootForm::text('Name', 'name')->required() !!}
        <div id="cp2" class="input-group colorpicker-component">
            <input type="text" value="#00AABB" class="form-control" id="hex_code" name="hex_code"/>
            <span class="input-group-addon"><i></i></span>
        </div>
        {!! BootForm::submit('Submit') !!}
        {!! BootForm::close() !!}
    @endif

    @if($colors->count() > 0)
        <table class="table table-striped sorted_table">
            <thead>
            <tr>
                <th>Color</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($colors as $color)
                <tr data-id="{{ $color->id }}">
                    <th>
                        <a href="/admin/color/{{ $color->id }}/edit">{{ $color->name }}</a>
                    </th>
                    <td>
                        @if(auth()->guard('web')->user()->isSuperUser() || auth()->guard('web')->user()->can('delete-colors'))
                            {!! BootForm::open()->action(route('color.destroy', $color->id))->delete() !!}
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
                You currently do not have any Filament Colors setup in your system.
            </p>
        </div>
    @endif

@endsection

@push('styles')
    <link rel="stylesheet" href="/css/jquery-sortable.css" />
@endpush

@push('custom-scripts')
    <!-- Bootstrap Colorpicker -->
    <script src="/js/bootstrap-colorpicker.min.js"></script>
    <script>
        $(function() {
            $('#cp2').colorpicker();
        });
    </script>
    <script src="/js/jquery-sortable.min.js"></script>
    <script>
        $(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var $table = $('.sorted_table').sortable({
                containerSelector: 'table',
                itemPath: '> tbody',
                itemSelector: 'tr',
                delay: 100,
                placeholder: '<tr class="placeholder"/>',
                onDrop: function  ($item, container, _super) {
                    var data = $table.sortable("serialize").get();

                    var jsonString = JSON.stringify(data, null, ' ');

                    _super($item, container);
                    $.ajax({
                        type: "POST",
                        url: '{{ route('color.sort') }}',
                        data: {'order': jsonString},
                        dataType: "json",
                        success: function (data) {

                        },
                        error: function (data) {

                        }
                    });
                }
            });
        });
    </script>
@endpush