@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/claimdocs') }}">ClaimDoc</a> :
@endsection
@section("contentheader_description", $claimdoc->$view_col)
@section("section", "ClaimDocs")
@section("section_url", url(config('laraadmin.adminRoute') . '/claimdocs'))
@section("sub_section", "Edit")

@section("htmlheader_title", "ClaimDocs Edit : ".$claimdoc->$view_col)

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
				{!! Form::model($claimdoc, ['route' => [config('laraadmin.adminRoute') . '.claimdocs.update', $claimdoc->id ], 'method'=>'PUT', 'id' => 'claimdoc-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'claim_id')
					@la_input($module, 'file_id')
					@la_input($module, 'type')
					@la_input($module, 'creator_uid')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/claimdocs') }}">Cancel</a></button>
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
	$("#claimdoc-edit-form").validate({
		
	});
});
</script>
@endpush
