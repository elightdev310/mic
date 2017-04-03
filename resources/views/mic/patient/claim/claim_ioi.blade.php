@extends('mic.layouts.patient')

@section('htmlheader_title')Claim #{{$claim->id}} - IOI @endsection

@section('page_id')patient-claim-ioi-page @endsection
@section('page_classes')claim-page patient-claim-page @endsection

@section('content')
<div id="page-content" class="profile2">
  <div class="bg-primary clearfix">
    
  </div>

  @include('mic.patient.claim.partials.claim_view_tab')

  <!-- IOI -->
  <div id="tab-ioi">
    <div class="tab-content">
      <div class="panel infolist">
        <div class="panel-default panel-heading">
          <div class="row">
            <div class="col-sm-6">
              <h4>Incident of Injury Information</h4>
            </div>
            <div class="col-sm-6">
              <button id="UpdateIOI" class="btn btn-success btn-sm pull-right mt5">Save Changes</button>
            </div>
          </div>
        </div>
        <div class="panel-body">
          @include('mic.commons.success_error')

          @include('mic.patient.claim.partials.ioi')
        </div>
      </div>
    </div>
  </div>

</div>

@endsection