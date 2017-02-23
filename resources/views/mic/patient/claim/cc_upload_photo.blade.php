@extends('mic.layouts.patient')

@section('htmlheader_title')
  Upload Photos in Claim
@endsection

@section('page_id')cc-upload-photo @endsection
@section('page_classes')cc-page @endsection

@section('content')
<div class="register-box">
  <h3 class="text-center mb30">You can upload photos here.</h3>
  <div class="row">
    <div class="col-xs-12 text-center">
      <a class="btn btn-primary form-control" href="{{ route('patient.claim.create.complete', [$claim->id]) }}">Continue</a>
    </div>
  </div>
</div>

</div>

@endsection
