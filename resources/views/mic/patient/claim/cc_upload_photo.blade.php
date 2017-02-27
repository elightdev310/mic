@extends('mic.layouts.patient')

@section('htmlheader_title')
  Upload Photos in Claim
@endsection

@section('page_id')cc-upload-photo @endsection
@section('page_classes')cc-page @endsection

@section('content')
<div class="">
  <h3 class="text-center mb30">You can upload photos here.</h3>
  <div class="row">
    <div class="col-sm-6 pull-right m20">
      <button id="AddNewPhotos" class="btn btn-success btn-sm pull-right mt5">Add New Photos</button>
    </div>
  </div>
  <div class="row">
    @include('mic.patient.claim.partials.photos')
  </div>
  <div class="row">
    <div class="col-xs-12 text-center">
      <a class="btn btn-primary" href="{{ route('patient.claim.create.complete', [$claim->id]) }}">Continue</a>
    </div>
  </div>
</div>

</div>

@endsection
