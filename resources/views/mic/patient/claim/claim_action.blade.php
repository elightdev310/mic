@extends('mic.layouts.patient')

@section('htmlheader_title')Claim #{{$claim->id}} - Action @endsection

@section('page_id')patient-claim-action-page @endsection
@section('page_classes')claim-page patient-claim-page @endsection

@section('content')
<div id="page-content" class="profile2">
  <div class="bg-primary clearfix">
    
  </div>

  @include('mic.patient.claim.partials.claim_view_tab')

  <!-- Action -->
  <div id="tab-action">
    <div class="tab-content">
      <div class="panel infolist">
        <div class="panel-default panel-heading">
          <h4>Action</h4>
        </div>
        <div class="panel-body">
          @include('mic.patient.claim.partials.action')
        </div>
      </div>
    </div>
  </div>

</div>

@endsection
