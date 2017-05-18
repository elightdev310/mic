@extends('mic.layouts.patient')

@section('htmlheader_title')Claim #{{$claim->id}} - Documents @endsection

@section('page_id')patient-claim-docs-page @endsection
@section('page_classes')claim-page patient-claim-page @endsection

@section('content')
<div id="page-content" class="profile2">
  <div class="bg-primary clearfix">
    
  </div>

  @include('mic.patient.claim.partials.claim_view_header')

  <!-- Docs -->
  <div id="tab-docs">
    <div class="tab-content">

        <div class="row">
          <div class="col-sm-6">
            <h2 class="text-color-primary claim-view-title"><strong>Docs</strong></h2>
          </div>
          <div class="col-sm-6">
            <button id="AddNewDoc" class="btn btn-primary pull-right mt20 mb10">Add New Document</button>
          </div>
        </div>

        <div class="content-box white infolist p10">
          @include('mic.patient.claim.partials.docs')
        </div>
      </div>
    </div>
  </div>

</div>

@endsection
