@extends('mic.layouts.admin')

@section('htmlheader_title')Add Injury Question @endsection
@section('contentheader_title')Add Injury Question @endsection
@section("section", "Injury Questions")
@section("section_url", route('micadmin.iquiz.list'))
@section("sub_section", "Add")

@section('main-content')
<!-- Main content -->
  <div class="row">
    <section class="col-md-12">

      <div class="users-box box box-success">
        {!! Form::open(['route'=>'micadmin.iquiz.add.post', 'method'=>'post']) !!}
        <div class="box-header">
          
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="form-group">
            {!! Form::label('quiz', "Question: ") !!}
            {!! Form::textarea('quiz', null, ['rows'=>'3', 'class'=>'form-control']) !!}
          </div>

          <div class="form-group">
            {!! Form::label('show_creating', "Show in Creating: ") !!}
            {!! 
              Form::select('show_creating', 
                            [0=>"Not Show", 1=>"Show"],
                            0, 
                            ['class' => 'form-control']) 
            !!}
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
@endsection

