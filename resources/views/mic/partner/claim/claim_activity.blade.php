@extends('mic.layouts.partner')

@section('htmlheader_title')Claim #{{$claim->id}} - Activity @endsection

@section('page_id')partner-claim-activity-page @endsection
@section('page_classes')claim-page partner-activity-page @endsection

@section('content')
<div id="page-content" class="profile2">
  <div class="bg-primary clearfix">
    
  </div>

  @include('mic.partner.claim.partials.claim_view_tab')

  <!-- Activity -->
  <div id="tab-activity">
    <div class="tab-content">
      <div class="panel infolist">
        <div class="panel-default panel-heading">
          <h4>Activity</h4>
        </div>
        <div class="panel-body">
          @include('mic.patient.claim.partials.activity')
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
