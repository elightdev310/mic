@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/paymentinfos') }}">PaymentInfo</a> :
@endsection
@section("contentheader_description", $paymentinfo->$view_col)
@section("section", "PaymentInfos")
@section("section_url", url(config('laraadmin.adminRoute') . '/paymentinfos'))
@section("sub_section", "Edit")

@section("htmlheader_title", "PaymentInfos Edit : ".$paymentinfo->$view_col)

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
				{!! Form::model($paymentinfo, ['route' => [config('laraadmin.adminRoute') . '.paymentinfos.update', $paymentinfo->id ], 'method'=>'PUT', 'id' => 'paymentinfo-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'name_card')
					@la_input($module, 'cc_number')
					@la_input($module, 'exp')
					@la_input($module, 'cid')
					@la_input($module, 'address')
					@la_input($module, 'address2')
					@la_input($module, 'city')
					@la_input($module, 'state')
					@la_input($module, 'zip')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/paymentinfos') }}">Cancel</a></button>
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
	$("#paymentinfo-edit-form").validate({
		
	});
});
</script>
@endpush
