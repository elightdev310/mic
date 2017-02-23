@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/claims') }}">Claim</a> :
@endsection
@section("contentheader_description", $claim->$view_col)
@section("section", "Claims")
@section("section_url", url(config('laraadmin.adminRoute') . '/claims'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Claims Edit : ".$claim->$view_col)

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
				{!! Form::model($claim, ['route' => [config('laraadmin.adminRoute') . '.claims.update', $claim->id ], 'method'=>'PUT', 'id' => 'claim-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'answers')
					@la_input($module, 'patient_uid')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/claims') }}">Cancel</a></button>
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
	$("#claim-edit-form").validate({
		
	});
});
</script>
@endpush
