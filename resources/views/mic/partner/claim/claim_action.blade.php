@extends('mic.layouts.partner')

@section('htmlheader_title')Claim #{{$claim->id}} - Action @endsection

@section('page_id')parnter-claim-action-page @endsection
@section('page_classes')claim-page parnter-claim-page @endsection

@section('content')
<div id="page-content" class="profile2">
  <div class="bg-primary clearfix">
    
  </div>

  @include('mic.partner.claim.partials.claim_view_header')

  <!-- Action -->
  <div id="tab-action">
    <div class="tab-content">
      <h2 class="text-color-primary claim-view-title"><strong>Actions</strong></h2>
      <div class="content-box white infolist p10">
        @include('mic.partner.claim.partials.action')
      </div>
    </div>
  </div>

</div>

@endsection
