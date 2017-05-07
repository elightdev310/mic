@extends('mic.layouts.partner')

@section('htmlheader_title')Claim #{{$claim->id}} - Activity @endsection

@section('page_id')partner-claim-activity-page @endsection
@section('page_classes')claim-page partner-activity-page @endsection

@section('content')
<div id="page-content" class="profile2">
  <div class="bg-primary clearfix">
    
  </div>

  @include('mic.partner.claim.partials.claim_view_header')

  <!-- Activity -->
  <div id="tab-activity">
    <div class="tab-content">
      <h2 class="text-color-primary claim-view-title"><strong>Activity</strong></h2>
      <div class="content-box white infolist p10">
        @include('mic.patient.claim.partials.activity')
      </div>
    </div>
  </div>

</div>
@endsection
