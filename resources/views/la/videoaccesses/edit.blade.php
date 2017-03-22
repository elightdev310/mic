@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/videoaccesses') }}">VideoAccess</a> :
@endsection
@section("contentheader_description", $videoaccess->$view_col)
@section("section", "VideoAccesses")
@section("section_url", url(config('laraadmin.adminRoute') . '/videoaccesses'))
@section("sub_section", "Edit")

@section("htmlheader_title", "VideoAccesses Edit : ".$videoaccess->$view_col)

@section("main-content")

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="box">
	<div class="box-header">
		
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				{!! Form::model($videoaccess, ['route' => [config('laraadmin.adminRoute') . '.videoaccesses.update', $videoaccess->id ], 'method'=>'PUT', 'id' => 'videoaccess-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'video_id')
					@la_input($module, 'group')
					@la_input($module, 'user_id')
					@la_input($module, 'weight')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/videoaccesses') }}">Cancel</a></button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
	$("#videoaccess-edit-form").validate({
		
	});
});
</script>
@endpush
