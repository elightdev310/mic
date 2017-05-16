@foreach ($questions as $quiz)
<div class="form-group">
  <label class="control-label i-quiz"><strong>Q: {{ $quiz->quiz}}</strong></label>
  <div class="i-answer">
    A: {{ $answers[$quiz->id] }}
  </div>
</div>
@endforeach

<a href="#additional-questions" class="btn btn-info text-left form-control" data-toggle="collapse">Additional Answers</a>

<div id="additional-questions" class="collapse pt20">
  @foreach ($addi_questions as $quiz)
  <div class="form-group">
    <label class="control-label i-quiz"><strong>Q: {{ $quiz->quiz }}</strong></label>
    <div class="i-answer">
      A: {{ $addi_answers[$quiz->id] }}
    </div>
  </div>
  @endforeach
</div>
