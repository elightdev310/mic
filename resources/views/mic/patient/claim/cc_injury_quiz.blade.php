@extends('mic.layouts.patient')

@section('htmlheader_title')
  Create a Claim
@endsection

@section('page_id')cc-injury-quiz @endsection
@section('page_classes')cc-page @endsection

@section('content')
<div class="row">
<div class="col-sm-8 col-sm-offset-2">
<div class="box box-primary mt30">
  <div class="box-header with-border">
    <h3 class="box-title">Injury Questions</h3>
  </div>
  <div class="box-body">
  {!! Form::open(['route' => 'patient.claim.create.injury_quiz.post', 
                  'method'=>'post', 
                  'class' =>'injury-quiz-form materials-form']) !!}

    @foreach ($questions as $quiz)
    <div class="form-group">
      {!! Form::label('quiz', 'Q: '.$quiz->quiz, 
                      ['class' => 'control-label']) !!}
      <div class="form-material">
        {!! 
          Form::textarea("answer[$quiz->id]", isset($answers[$quiz->id])? $answers[$quiz->id] : '', 
                          ['class' => 'form-control', 'rows'=>2, 'placeholder'=>'']) 
        !!}
      </div>
    </div>
    @endforeach

    <div class="form-group">
      <div class="col-md-12 text-right p10">
        {!! Form::submit('Submit', ['class'=>'btn btn-primary']) !!}
      </div>
    </div>
  {!! Form::close() !!}
  </div>
</div><!-- .box -->
</div>
</div>

@endsection
