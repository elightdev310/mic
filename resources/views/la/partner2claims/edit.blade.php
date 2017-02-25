@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/partner2claims') }}">Partner2Claim</a> :
@endsection
@section("contentheader_description", $partner2claim->$view_col)
@section("section", "Partner2Claims")
@section("section_url", url(config('laraadmin.adminRoute') . '/partner2claims'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Partner2Claims Edit : ".$partner2claim->$view_col)

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
				{!! Form::model($partner2claim, ['route' => [config('laraadmin.adminRoute') . '.partner2claims.update', $partner2claim->id ], 'method'=>'PUT', 'id' => 'partner2claim-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'partner_uid')
					@la_input($module, 'claim_id')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/partner2claims') }}">Cancel</a></button>
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
	$("#partner2claim-edit-form").validate({
		
	});
});
</script>
@endpush
