@extends('mic.layouts.partner')

@section('htmlheader_title')Claim #{{$claim->id}} - Photos @endsection

@section('page_id')parnter-claim-photos-page @endsection
@section('page_classes')claim-page parnter-claim-page @endsection

@section('content')
<div id="page-content" class="profile2">
  <div class="bg-primary clearfix">
    
  </div>

  @include('mic.partner.claim.partials.claim_view_header')

  <!-- Photos -->
  <div id="tab-photos">
    <div class="tab-content">
      <h3 class="text-color-primary claim-view-title"><strong>Photos</strong></h3>
      <div class="content-box white infolist p10">
        @include('mic.partner.claim.partials.photos')
      </div>
    </div>
  </div>

</div>

@endsection
