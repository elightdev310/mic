{!! Form::open(['route' => ['patient.claim.update.ioi', $claim->id], 
                  'method'=>'post', 
                  'class' =>'injury-quiz-form materials-form']) !!}

@foreach ($questions as $quiz)
<div class="form-group">
  {!! Form::label('quiz', 'Q: '.$quiz->quiz, 
                      ['class' => 'control-label i-quiz']) !!}
  <div class="form-material">
  {!! 
    Form::textarea("answer[$quiz->id]", isset($answers[$quiz->id])? $answers[$quiz->id] : '', 
                    ['class' => 'form-control', 'rows'=>2, 'placeholder'=>'']) 
  !!}
  </div>
</div>
@endforeach

<a href="#additional-questions" class="btn btn-info text-left form-control" data-toggle="collapse">Additional Answers</a>

<div id="additional-questions" class="collapse">
  @foreach ($addi_questions as $quiz)
  <div class="form-group">
    {!! Form::label('quiz', 'Q: '.$quiz->quiz, 
                        ['class' => 'control-label i-quiz']) !!}
    <div class="form-material">
    {!! 
      Form::textarea("answer[$quiz->id]", isset($addi_answers[$quiz->id])? $addi_answers[$quiz->id] : '', 
                      ['class' => 'form-control', 'rows'=>2, 'placeholder'=>'']) 
    !!}
    </div>
  </div>
  @endforeach
</div>

{!! Form::close() !!}


@push('scripts')
<script>
$(function () {
  $('#UpdateIOI').on('click', function() {
    $('.injury-quiz-form').submit();
  });
});
</script>
@endpush
