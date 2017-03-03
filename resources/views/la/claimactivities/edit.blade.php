@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/claimactivities') }}">ClaimActivity</a> :
@endsection
@section("contentheader_description", $claimactivity->$view_col)
@section("section", "ClaimActivities")
@section("section_url", url(config('laraadmin.adminRoute') . '/claimactivities'))
@section("sub_section", "Edit")

@section("htmlheader_title", "ClaimActivities Edit : ".$claimactivity->$view_col)

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
				{!! Form::model($claimactivity, ['route' => [config('laraadmin.adminRoute') . '.claimactivities.update', $claimactivity->id ], 'method'=>'PUT', 'id' => 'claimactivity-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'claim_id')
					@la_input($module, 'content')
					@la_input($module, 'author_uid')
					@la_input($module, 'type')
					@la_input($module, 'public_patient')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/claimactivities') }}">Cancel</a></button>
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
	$("#claimactivity-edit-form").validate({
		
	});
});
</script>
@endpush
