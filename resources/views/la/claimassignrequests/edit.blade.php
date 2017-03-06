@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/claimassignrequests') }}">ClaimAssignRequest</a> :
@endsection
@section("contentheader_description", $claimassignrequest->$view_col)
@section("section", "ClaimAssignRequests")
@section("section_url", url(config('laraadmin.adminRoute') . '/claimassignrequests'))
@section("sub_section", "Edit")

@section("htmlheader_title", "ClaimAssignRequests Edit : ".$claimassignrequest->$view_col)

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
				{!! Form::model($claimassignrequest, ['route' => [config('laraadmin.adminRoute') . '.claimassignrequests.update', $claimassignrequest->id ], 'method'=>'PUT', 'id' => 'claimassignrequest-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'claim_id')
					@la_input($module, 'partner_uid')
					@la_input($module, 'partner_approve')
					@la_input($module, 'patient_approve')
					@la_input($module, 'status')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/claimassignrequests') }}">Cancel</a></button>
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
	$("#claimassignrequest-edit-form").validate({
		
	});
});
</script>
@endpush
