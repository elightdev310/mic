@extends('mic.layouts.patient')

@section('htmlheader_title')Claim #{{$claim->id}} - Photos @endsection

@section('page_id')patient-claim-photos-page @endsection
@section('page_classes')claim-page patient-claim-page @endsection

@section('content')
<div id="page-content" class="profile2">
  <div class="bg-primary clearfix">
    
  </div>

  @include('mic.patient.claim.partials.claim_view_header')

  <!-- Photos -->
  <div id="tab-photos">
    <div class="tab-content">
      <div class="row">
        <div class="col-sm-6">
          <h2 class="text-color-primary claim-view-title"><strong>Photos</strong></h2>
        </div>
        <div class="col-sm-6">
          <button id="AddNewPhotos" class="btn btn-primary pull-right mt20 mb10">Add New Photos</button>
        </div>
      </div>

      <div class="content-box white infolist p10">
        @include('mic.patient.claim.partials.photos')
      </div>
    </div>
  </div>

</div>

@endsection
