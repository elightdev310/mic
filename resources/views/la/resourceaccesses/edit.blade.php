@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/resourceaccesses') }}">ResourceAccess</a> :
@endsection
@section("contentheader_description", $resourceaccess->$view_col)
@section("section", "ResourceAccesses")
@section("section_url", url(config('laraadmin.adminRoute') . '/resourceaccesses'))
@section("sub_section", "Edit")

@section("htmlheader_title", "ResourceAccesses Edit : ".$resourceaccess->$view_col)

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
				{!! Form::model($resourceaccess, ['route' => [config('laraadmin.adminRoute') . '.resourceaccesses.update', $resourceaccess->id ], 'method'=>'PUT', 'id' => 'resourceaccess-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'resource_id')
					@la_input($module, 'group')
					@la_input($module, 'weight')
					@la_input($module, 'status')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/resourceaccesses') }}">Cancel</a></button>
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
	$("#resourceaccess-edit-form").validate({
		
	});
});
</script>
@endpush
