@extends('mic.layouts.patient')

@section('htmlheader_title')Claim #{{$claim->id}} - IOI @endsection

@section('page_id')patient-claim-ioi-page @endsection
@section('page_classes')claim-page patient-claim-page @endsection

@section('content')
<div id="page-content" class="profile2">
  <div class="bg-primary clearfix">
    
  </div>

  @include('mic.patient.claim.partials.claim_view_header')

  <!-- IOI -->
  <div id="tab-ioi">
    <div class="tab-content">

        <div class="row">
          <div class="col-sm-6">
            <h2 class="text-color-primary claim-view-title"><strong>Incident Of Injury Information</strong></h2>
          </div>
          <div class="col-sm-6">
            <button id="UpdateIOI" class="btn btn-primary pull-right mt20 mb10">Save Changes</button>
          </div>
        </div>

        <div class="content-box white infolist p20">
          @include('mic.commons.success_error')

          @include('mic.patient.claim.partials.ioi')
        </div>

    </div>
  </div>

</div>

@endsection
