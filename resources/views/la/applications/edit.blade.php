@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/applications') }}">Application</a> :
@endsection
@section("contentheader_description", $application->$view_col)
@section("section", "Applications")
@section("section_url", url(config('laraadmin.adminRoute') . '/applications'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Applications Edit : ".$application->$view_col)

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
				{!! Form::model($application, ['route' => [config('laraadmin.adminRoute') . '.applications.update', $application->id ], 'method'=>'PUT', 'id' => 'application-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'email')
					@la_input($module, 'first_name')
					@la_input($module, 'last_name')
					@la_input($module, 'pwd')
					@la_input($module, 'partner_id')
					@la_input($module, 'user_id')
					@la_input($module, 'status')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/applications') }}">Cancel</a></button>
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
	$("#application-edit-form").validate({
		
	});
});
</script>
@endpush
