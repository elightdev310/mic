@extends('mic.layouts.admin')

@section('htmlheader_title')Add Youtube Video @endsection
@section('contentheader_title')Add Youtube Video @endsection
@section("section", "Video for User")
@section("section_url", route('micadmin.user.settings', [$user_id])."?panel=LearningCenter")
@section("sub_section", "Add")

@section('main-content')
<!-- Main content -->
<section class="content">
  <div class="row">
    <section class="col-md-12">

      @include('mic.admin.partials.success_error')

      <div class="users-box box box-success">
        {!! Form::open(['route'=>['micadmin.user.learning_video.add.post', $user_id], 'method'=>'post']) !!}
        <div class="box-header">
          
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="form-group">
            {!! Form::label('vid', "Youtube Video ID*: ") !!}
            {!! Form::text('vid', null, ['class'=>'form-control']) !!}
          </div>
          <div class="form-group">
            <label>
            {!! 
              Form::checkbox('non_free', 'yes');
            !!}
            Is this non-free video (${{ number_format(config('mic.video_price'), 2) }})?
            </label>
          </div>

        </div><!-- /.box-body -->
        <div class="box-footer clearfix no-border">
          <div class="paginator pull-right">
            {!! Form::submit('Add', ['class'=>'btn btn-success']) !!}
          </div>
        </div>

        {!! Form::close() !!}
      </div><!-- /.box -->

    </section>
  </div>
</section><!-- /.content -->
@endsection

