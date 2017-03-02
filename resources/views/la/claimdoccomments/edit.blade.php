@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/claimdoccomments') }}">ClaimDocComment</a> :
@endsection
@section("contentheader_description", $claimdoccomment->$view_col)
@section("section", "ClaimDocComments")
@section("section_url", url(config('laraadmin.adminRoute') . '/claimdoccomments'))
@section("sub_section", "Edit")

@section("htmlheader_title", "ClaimDocComments Edit : ".$claimdoccomment->$view_col)

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
				{!! Form::model($claimdoccomment, ['route' => [config('laraadmin.adminRoute') . '.claimdoccomments.update', $claimdoccomment->id ], 'method'=>'PUT', 'id' => 'claimdoccomment-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'comment')
					@la_input($module, 'doc_id')
					@la_input($module, 'author_uid')
					@la_input($module, 'p_comment_id')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/claimdoccomments') }}">Cancel</a></button>
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
	$("#claimdoccomment-edit-form").validate({
		
	});
});
</script>
@endpush
