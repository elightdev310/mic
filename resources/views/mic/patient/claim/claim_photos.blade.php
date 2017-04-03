@extends('mic.layouts.patient')

@section('htmlheader_title')Claim #{{$claim->id}} - Photos @endsection

@section('page_id')patient-claim-photos-page @endsection
@section('page_classes')claim-page patient-claim-page @endsection

@section('content')
<div id="page-content" class="profile2">
  <div class="bg-primary clearfix">
    
  </div>

  @include('mic.patient.claim.partials.claim_view_tab')

  <!-- Photos -->
  <div id="tab-photos">
    <div class="tab-content">
      <div class="panel infolist">
        <div class="panel-default panel-heading">
          <div class="row">
            <div class="col-sm-6">
              <h4>Photos</h4>
            </div>
            <div class="col-sm-6">
              <button id="AddNewPhotos" class="btn btn-success btn-sm pull-right mt5">Add New Photos</button>
            </div>
          </div>
        </div>
        <div class="panel-body">
          @include('mic.patient.claim.partials.photos')
        </div>
      </div>
    </div>
  </div>

</div>

@endsection
