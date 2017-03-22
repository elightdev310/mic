@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/youtubevideos') }}">YoutubeVideo</a> :
@endsection
@section("contentheader_description", $youtubevideo->$view_col)
@section("section", "YoutubeVideos")
@section("section_url", url(config('laraadmin.adminRoute') . '/youtubevideos'))
@section("sub_section", "Edit")

@section("htmlheader_title", "YoutubeVideos Edit : ".$youtubevideo->$view_col)

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
				{!! Form::model($youtubevideo, ['route' => [config('laraadmin.adminRoute') . '.youtubevideos.update', $youtubevideo->id ], 'method'=>'PUT', 'id' => 'youtubevideo-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'vid')
					@la_input($module, 'vdata')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/youtubevideos') }}">Cancel</a></button>
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
	$("#youtubevideo-edit-form").validate({
		
	});
});
</script>
@endpush
