@extends('mic.layouts.admin')

@section('htmlheader_title')Claim #{{$claim->id}} - IOI @endsection

@section('page_id')admin-claim-ioi-page @endsection
@section('page_classes')claim-page admin-claim-page @endsection

@section('main-content')
<div id="page-content" class="profile2">
  <div class="bg-primary clearfix">
    
  </div>

  @include('mic.admin.claim.partials.claim_view_tab')

  <!-- IOI -->
  <div id="tab-ioi">
    <!-- IOI -->
    <div id="tab-ioi">
      <div class="tab-content">
        <div class="panel infolist">
          <div class="panel-default panel-heading">
            <h4>Incident of Injury Information</h4>
          </div>
          <div class="panel-body">
            @include('mic.partner.claim.partials.ioi')
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

@endsection
