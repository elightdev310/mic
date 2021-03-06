@extends('mic.layouts.patient')

@section('htmlheader_title')Claim #{{$claim->id}} - Partners @endsection

@section('page_id')patient-claim-partners-page @endsection
@section('page_classes')claim-page patient-claim-page @endsection

@section('content')
<div id="page-content" class="profile2">
  <div class="bg-primary clearfix">
    
  </div>

  @include('mic.patient.claim.partials.claim_view_header')

  <!-- Partners -->
  <div id="tab-partners">
    <div class="tab-content">
      <h2 class="text-color-primary claim-view-title"><strong>Partners</strong></h2>
      <div class="content-box white infolist p10">
          @include('mic.admin.partials.success_error')
          @include('mic.patient.claim.partials.partners')
      </div>
    </div>
  </div>

</div>

@endsection
