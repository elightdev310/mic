@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/subscriptions') }}">Subscription</a> :
@endsection
@section("contentheader_description", $subscription->$view_col)
@section("section", "Subscriptions")
@section("section_url", url(config('laraadmin.adminRoute') . '/subscriptions'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Subscriptions Edit : ".$subscription->$view_col)

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
				{!! Form::model($subscription, ['route' => [config('laraadmin.adminRoute') . '.subscriptions.update', $subscription->id ], 'method'=>'PUT', 'id' => 'subscription-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'user_id')
					@la_input($module, 'name')
					@la_input($module, 'plan')
					@la_input($module, 'trial_ends_at')
					@la_input($module, 'ends_at')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/subscriptions') }}">Cancel</a></button>
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
	$("#subscription-edit-form").validate({
		
	});
});
</script>
@endpush
