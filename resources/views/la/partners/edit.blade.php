@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/partners') }}">Partner</a> :
@endsection
@section("contentheader_description", $partner->$view_col)
@section("section", "Partners")
@section("section_url", url(config('laraadmin.adminRoute') . '/partners'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Partners Edit : ".$partner->$view_col)

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
				{!! Form::model($partner, ['route' => [config('laraadmin.adminRoute') . '.partners.update', $partner->id ], 'method'=>'PUT', 'id' => 'partner-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'first_name')
					@la_input($module, 'last_name')
					@la_input($module, 'company')
					@la_input($module, 'phone')
					@la_input($module, 'address')
					@la_input($module, 'address2')
					@la_input($module, 'city')
					@la_input($module, 'state')
					@la_input($module, 'zip')
					@la_input($module, 'membership_role')
					@la_input($module, 'membership_level')
					@la_input($module, 'payment_type')
					@la_input($module, 'payment_info_id')
					@la_input($module, 'user_id')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/partners') }}">Cancel</a></button>
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
	$("#partner-edit-form").validate({
		
	});
});
</script>
@endpush
