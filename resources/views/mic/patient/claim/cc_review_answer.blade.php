@extends('mic.layouts.patient')

@section('htmlheader_title')
  Create a Claim
@endsection

@section('page_id')cc-review-answer @endsection
@section('page_classes')cc-page @endsection

@section('content')
<div class="row">
<div class="col-sm-8 col-sm-offset-2">
<div class="box box-primary mt30">
  <div class="box-header with-border">
    <h3 class="box-title">Review Answer</h3>
  </div>
  <div class="box-body">
    @foreach ($questions as $quiz)
    <div class="form-group">
      <label class="control-label i-quiz"><strong>Q: {{ $quiz->quiz}}</strong></label>
      <div class="i-answer">
        A: {{ $answers[$quiz->id] }}
      </div>
    </div>
    @endforeach

    <div class="form-group">
      <div class="col-md-12 text-right p10">
        <a id="submit-link" href="#" 
          class="btn btn-primary">Submit</a>
      </div>
    </div>

  </div>
</div><!-- .box -->
</div>
</div>

@endsection

@push('scripts')
<script>
(function ($) {
$(document).ready(function() {
  $('a#submit-link').click(function() {
    var submit_url  = '{{ route('patient.claim.create.submit') }}';
    var edit_url    = '{{ route('patient.claim.create.injury_quiz') }}';
    var cancel_url  = '{{ route('patient.claim.create.cancel_submit') }}';
    bootbox.confirm({
      title: 'Confirm', 
      message: "<p>Information is True & Accurate to the best of their knowledge.</p>",
      callback: function (result) {
        if (result) {
          window.location.href = submit_url;
        } else {
          bootbox.confirm({
            message: "<p>Would you like to edit answer?</p>",
            buttons: {
              confirm: {
                  label: 'Yes',
                  className: 'btn-success'
              },
              cancel: {
                  label: 'No',
                  className: 'btn-warning'
              }
            },
            callback: function (result) {
              if (result) {
                window.location.href = edit_url;
              } else {
                window.location.href = cancel_url;
              }
            }
          });
          }
      }
    });
  });
});
}(jQuery));
</script>
@endpush
