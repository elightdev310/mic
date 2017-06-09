@extends('mic.layouts.partner')

@section('htmlheader_title')Claim #{{$claim->id}} - Documents @endsection

@section('page_id')parnter-claim-docs-page @endsection
@section('page_classes')claim-page parnter-claim-page @endsection

@section('content')
<div id="page-content" class="profile2">
  <div class="bg-primary clearfix">
    
  </div>

  @include('mic.partner.claim.partials.claim_view_header')

  <!-- Docs -->
  <div id="tab-docs">
    <div class="tab-content">

        <div class="row">
          <div class="col-sm-6">
            <h2 class="text-color-primary claim-view-title"><strong>Docs</strong></h2>
          </div>
          <div class="col-sm-6 text-right">
            <button id="AddNewDoc" class="btn btn-primary mt20 mb10" data-toggle="modal" data-target="#upload-doc-modal">Add New Document</button> 
            <span>&nbsp;&nbsp;</span>
            <button id="AddNewMsg" class="btn btn-primary mt20 mb10" data-toggle="modal" data-target="#upload-message-modal">Add HL7 Message</button>
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
