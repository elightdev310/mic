@extends('mic.layouts.admin')

@section('htmlheader_title')Claim #{{$claim->id}} - Documents @endsection

@section('page_id')admin-claim-docs-page @endsection
@section('page_classes')claim-page admin-claim-page @endsection

@section('main-content')
<div id="page-content" class="profile2">
  <div class="bg-primary clearfix">
    
  </div>

  @include('mic.admin.claim.partials.claim_view_tab')

  <!-- Docs -->
  <div id="tab-docs">
    <div class="tab-content">
      <div class="panel infolist">
        <div class="panel-default panel-heading">
          <h4>Docs</h4>
        </div>
        <div class="panel-body">
          @include('mic.patient.claim.partials.docs')
        </div>
      </div>
    </div>
  </div>

</div>

@endsection
