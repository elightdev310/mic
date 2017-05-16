@extends('mic.layouts.partner')

@section('htmlheader_title')Claim #{{$claim->id}} - IOI @endsection

@section('page_id')partner-claim-ioi-page @endsection
@section('page_classes')claim-page partner-claim-page @endsection

@section('content')
<div id="page-content" class="profile2">
  <div class="bg-primary clearfix">
    
  </div>

  @include('mic.partner.claim.partials.claim_view_header')

  <!-- IOI -->
  <div id="tab-ioi">
    <div class="tab-content">

      <h2 class="text-color-primary claim-view-title"><strong>Incident of Injury Information</strong></h2>
      <div class="content-box white infolist p20">
        @include('mic.partner.claim.partials.ioi')
      </div>

    </div>
  </div>

</div>

@endsection
