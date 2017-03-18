@extends('mic.layouts.admin')

@section('htmlheader_title')Edit Injury Question @endsection
@section('contentheader_title')Edit Injury Question @endsection
@section("section", "Injury Questions")
@section("section_url", route('micadmin.iquiz.list'))
@section("sub_section", "Edit")

@section('main-content')
<!-- Main content -->
<section class="content">
  <div class="row">
    <section class="col-md-12">

      @include('mic.admin.partials.success_error')

      <div class="users-box box box-success">
        {!! Form::open(['route'=>['micadmin.iquiz.edit.post', $quiz->id], 'method'=>'post']) !!}
        <div class="box-header">
          
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="form-group">
            {!! Form::label('quiz', "Question: ") !!}
            {!! Form::textarea('quiz', $quiz->quiz, ['rows'=>'3', 'class'=>'form-control']) !!}
          </div>
          <div class="form-group">
            {!! Form::label('show_creating', "Show in Creating: ") !!}
            {!! 
              Form::select('show_creating', 
                            [0=>"Not Show", 1=>"Show"],
                            $quiz->show_creating, 
                            ['class' => 'form-control']) 
            !!}
          </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix no-border">
          <div class="paginator pull-right">
            {!! Form::submit('Save', ['class'=>'btn btn-success']) !!}
          </div>
        </div>

        {!! Form::close() !!}
      </div><!-- /.box -->

    </section>
  </div>
</section><!-- /.content -->
@endsection
