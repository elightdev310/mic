@extends('mic.layouts.admin')

@section('htmlheader_title')Claim #{{$claim->id}} - Action @endsection

@section('page_id')admin-claim-action-page @endsection
@section('page_classes')claim-page admin-claim-page @endsection

@section('main-content')
<div id="page-content" class="profile2">
  <div class="bg-primary clearfix">
    
  </div>

  @include('mic.admin.claim.partials.claim_view_tab')

  <!-- Action -->
  <div id="tab-action">
    <div class="tab-content">
      <div class="panel infolist">
        <div class="panel-default panel-heading">
          <h4>Action</h4>
        </div>
        <div class="panel-body">
          @include('mic.admin.partials.success_error')
          @include('mic.admin.claim.partials.action')
        </div>
      </div>
    </div>
  </div>

</div>

@endsection
