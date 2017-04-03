@extends('mic.layouts.partner')

@section('htmlheader_title')Claim #{{$claim->id}} - Photos @endsection

@section('page_id')parnter-claim-photos-page @endsection
@section('page_classes')claim-page parnter-claim-page @endsection

@section('content')
<div id="page-content" class="profile2">
  <div class="bg-primary clearfix">
    
  </div>

  @include('mic.partner.claim.partials.claim_view_tab')

  <!-- Photos -->
  <div id="tab-photos">
    <div class="tab-content">
      <div class="panel infolist">
        <div class="panel-default panel-heading">
          <h4>Photos</h4>
        </div>
        <div class="panel-body">
          @include('mic.partner.claim.partials.photos')
        </div>
      </div>
    </div>
  </div>

</div>

@endsection
