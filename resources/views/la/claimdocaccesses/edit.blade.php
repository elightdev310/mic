@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/claimdocaccesses') }}">ClaimDocAccess</a> :
@endsection
@section("contentheader_description", $claimdocaccess->$view_col)
@section("section", "ClaimDocAccesses")
@section("section_url", url(config('laraadmin.adminRoute') . '/claimdocaccesses'))
@section("sub_section", "Edit")

@section("htmlheader_title", "ClaimDocAccesses Edit : ".$claimdocaccess->$view_col)

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
				{!! Form::model($claimdocaccess, ['route' => [config('laraadmin.adminRoute') . '.claimdocaccesses.update', $claimdocaccess->id ], 'method'=>'PUT', 'id' => 'claimdocaccess-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'doc_id')
					@la_input($module, 'partner_uid')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/claimdocaccesses') }}">Cancel</a></button>
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
	$("#claimdocaccess-edit-form").validate({
		
	});
});
</script>
@endpush
