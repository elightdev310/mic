@foreach ($questions as $quiz)
<div class="form-group">
  <label class="control-label i-quiz"><strong>Q: {{ $quiz->quiz}}</strong></label>
  <div class="i-answer">
    A: {{ $answers[$quiz->id] }}
  </div>
</div>
@endforeach
