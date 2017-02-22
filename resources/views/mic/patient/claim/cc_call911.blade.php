@extends('mic.layouts.patient')

@section('htmlheader_title')
  Create a Claim
@endsection

@section('page_id')cc-call911-page @endsection
@section('page_classes')cc-page @endsection

@section('content')
<div class="register-box">
  <h3 class="text-center mb30">If you are currently at the scene of an accident & Police/Medical help has not been contacted, please call <strong>911</strong> now. If they have already been notified, please continue.</h3>
  <div class="row">
    <div class="col-xs-6 col-xs-offset-3">
      <a class="btn btn-primary form-control" href="{{ route('patient.claim.create.injury_quiz') }}">Continue</a>
    </div>
  </div>
</div>

</div>

@endsection
