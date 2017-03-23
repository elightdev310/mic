@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/notifications') }}">Notification</a> :
@endsection
@section("contentheader_description", $notification->$view_col)
@section("section", "Notifications")
@section("section_url", url(config('laraadmin.adminRoute') . '/notifications'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Notifications Edit : ".$notification->$view_col)

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
				{!! Form::model($notification, ['route' => [config('laraadmin.adminRoute') . '.notifications.update', $notification->id ], 'method'=>'PUT', 'id' => 'notification-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'message')
					@la_input($module, 'user_id')
					@la_input($module, 'read')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/notifications') }}">Cancel</a></button>
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
	$("#notification-edit-form").validate({
		
	});
});
</script>
@endpush
