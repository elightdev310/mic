@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/iquestions') }}">IQuestion</a> :
@endsection
@section("contentheader_description", $iquestion->$view_col)
@section("section", "IQuestions")
@section("section_url", url(config('laraadmin.adminRoute') . '/iquestions'))
@section("sub_section", "Edit")

@section("htmlheader_title", "IQuestions Edit : ".$iquestion->$view_col)

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
				{!! Form::model($iquestion, ['route' => [config('laraadmin.adminRoute') . '.iquestions.update', $iquestion->id ], 'method'=>'PUT', 'id' => 'iquestion-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'quiz')
					@la_input($module, 'show_creating')
					@la_input($module, 'weight')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/iquestions') }}">Cancel</a></button>
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
	$("#iquestion-edit-form").validate({
		
	});
});
</script>
@endpush
