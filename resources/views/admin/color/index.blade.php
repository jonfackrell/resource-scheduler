@extends('layouts.admin')

@section('content')

    {!! BootForm::open()->action(route('color.index'))->post() !!}

    {!! BootForm::text('Name', 'name')->required() !!}

    <div id="cp2" class="input-group colorpicker-component">
    <input type="text" value="#00AABB" class="form-control" id="hex_code" name="hex_code"/>
    <span class="input-group-addon"><i></i></span>
	</div>
	

    {!! BootForm::submit('Submit') !!}

    {!! BootForm::close() !!}

    





    @foreach($colors as $color)

        <p>
            <a href="/admin/color/{{ $color->id }}/edit">{{ $color->name }}</a>
        </p>

    @endforeach

@endsection

@push('custom-scripts')
	<!-- Bootstrap Colorpicker -->
	<script src="/js/bootstrap-colorpicker.min.js"></script>
	<script>
        $(function() {
            $('#cp2').colorpicker();
        });
    </script>
@endpush