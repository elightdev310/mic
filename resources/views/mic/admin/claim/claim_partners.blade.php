@extends('mic.layouts.admin')

@section('htmlheader_title')Claim #{{$claim->id}} - Partners @endsection

@section('page_id')admin-claim-partners-page @endsection
@section('page_classes')claim-page admin-claim-page @endsection

@section('main-content')
<div id="page-content" class="profile2">
  <div class="bg-primary clearfix">
    
  </div>

  @include('mic.admin.claim.partials.claim_view_tab')

  <!-- Partners -->
  <div id="tab-partners">
    <div class="tab-content">
    
      <div class="panel infolist assigned-partners pb30">
        <div class="panel-default panel-heading">
          <h4>Assigned Partners</h4>
        </div>
        <div class="panel-body">
          @if (session('_panel')=='assign-partner')
            @include('mic.admin.partials.success_error')
          @endif
          @include('mic.admin.claim.partials.assigned_partners')
        </div>
      </div>

      @if (isset($assign_requests) && $assign_requests->count() > 0 )
      <div class="panel infolist assign-requests pb30">
        <div class="panel-default panel-heading">
          <h4>Assign Requests</h4>
        </div>
        <div class="panel-body">
          @include('mic.admin.claim.partials.assign_requests')
        </div>
      </div>
      @endif
      
      <div class="panel infolist partner-list">
        <div class="panel-default panel-heading">
          <h4>Partners</h4>
        </div>
        <div class="panel-body">
          @include('mic.admin.claim.partials.partner_list')
        </div>
      </div>

    </div>
  </div>

</div>

@endsection
