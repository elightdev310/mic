@extends('mic.layouts.patient')

@section('htmlheader_title')Claim #{{$claim->id}} - Documents @endsection

@section('page_id')patient-claim-docs-page @endsection
@section('page_classes')claim-page patient-claim-page @endsection

@section('content')
<div id="page-content" class="profile2">
  <div class="bg-primary clearfix">
    
  </div>

  @include('mic.patient.claim.partials.claim_view_tab')

  <!-- Docs -->
  <div id="tab-docs">
    <div class="tab-content">
      <div class="panel infolist">
        <div class="panel-default panel-heading">
          <div class="row">
            <div class="col-sm-6">
              <h4>Docs</h4>
            </div>
            <div class="col-sm-6">
              <button id="AddNewDoc" class="btn btn-success btn-sm pull-right mt5">Add New Document</button>
            </div>
          </div>
        </div>
        <div class="panel-body">
          @include('mic.patient.claim.partials.docs')
        </div>
      </div>
    </div>
  </div>

</div>

@endsection
