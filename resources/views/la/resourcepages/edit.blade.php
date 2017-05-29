@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/resourcepages') }}">ResourcePage</a> :
@endsection
@section("contentheader_description", $resourcepage->$view_col)
@section("section", "ResourcePages")
@section("section_url", url(config('laraadmin.adminRoute') . '/resourcepages'))
@section("sub_section", "Edit")

@section("htmlheader_title", "ResourcePages Edit : ".$resourcepage->$view_col)

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
				{!! Form::model($resourcepage, ['route' => [config('laraadmin.adminRoute') . '.resourcepages.update', $resourcepage->id ], 'method'=>'PUT', 'id' => 'resourcepage-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'title')
					@la_input($module, 'body')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/resourcepages') }}">Cancel</a></button>
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
	$("#resourcepage-edit-form").validate({
		
	});
});
</script>
@endpush
