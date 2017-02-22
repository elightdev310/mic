@extends('mic.layouts.patient')

@section('htmlheader_title')
  Create a Claim
@endsection

@section('page_id')cc-first-page @endsection
@section('page_classes')cc-page @endsection

@section('content')
<div class="register-box">
  <h2 class="text-center mb30">Have you called 911?</h2>
  <div class="row">
    <div class="col-xs-6">
      <a class="btn btn-primary form-control" href="{{ route('patient.claim.create.injury_quiz') }}">Yes</a>
    </div>
    <div class="col-xs-6">
      <a class="btn btn-warning form-control" href="{{ route('patient.claim.create.call911') }}">No</a>
    </div>
  </div>
</div>

</div>

@endsection
