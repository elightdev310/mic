@extends('mic.layouts.patient')

@section('htmlheader_title')Claim #{{$claim->id}} - Partners @endsection

@section('page_id')patient-claim-partners-page @endsection
@section('page_classes')claim-page patient-claim-page @endsection

@section('content')
<div id="page-content" class="profile2">
  <div class="bg-primary clearfix">
    
  </div>

  @include('mic.patient.claim.partials.claim_view_tab')

  <!-- Partners -->
  <div id="tab-partners">
    <div class="tab-content">
      <div class="panel infolist">
        <div class="panel-default panel-heading">
          <h4>Partners</h4>
        </div>
        <div class="panel-body">
          @include('mic.admin.partials.success_error')

          @include('mic.patient.claim.partials.partners')
        </div>
      </div>
    </div>
  </div>

</div>

@endsection
