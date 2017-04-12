@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/videotrackings') }}">VideoTracking</a> :
@endsection
@section("contentheader_description", $videotracking->$view_col)
@section("section", "VideoTrackings")
@section("section_url", url(config('laraadmin.adminRoute') . '/videotrackings'))
@section("sub_section", "Edit")

@section("htmlheader_title", "VideoTrackings Edit : ".$videotracking->$view_col)

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
				{!! Form::model($videotracking, ['route' => [config('laraadmin.adminRoute') . '.videotrackings.update', $videotracking->id ], 'method'=>'PUT', 'id' => 'videotracking-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'user_id')
					@la_input($module, 'vid')
					@la_input($module, 'state')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/videotrackings') }}">Cancel</a></button>
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
	$("#videotracking-edit-form").validate({
		
	});
});
</script>
@endpush
