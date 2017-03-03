@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/claimactivityfeeds') }}">ClaimActivityFeed</a> :
@endsection
@section("contentheader_description", $claimactivityfeed->$view_col)
@section("section", "ClaimActivityFeeds")
@section("section_url", url(config('laraadmin.adminRoute') . '/claimactivityfeeds'))
@section("sub_section", "Edit")

@section("htmlheader_title", "ClaimActivityFeeds Edit : ".$claimactivityfeed->$view_col)

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
				{!! Form::model($claimactivityfeed, ['route' => [config('laraadmin.adminRoute') . '.claimactivityfeeds.update', $claimactivityfeed->id ], 'method'=>'PUT', 'id' => 'claimactivityfeed-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'claim_id')
					@la_input($module, 'feeder_uid')
					@la_input($module, 'ca_id')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/claimactivityfeeds') }}">Cancel</a></button>
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
	$("#claimactivityfeed-edit-form").validate({
		
	});
});
</script>
@endpush
