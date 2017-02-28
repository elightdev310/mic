@extends('mic.layouts.patient')

@section('htmlheader_title')Claim #{{$claim->id}} @endsection

@section('page_id')patient-claim-page @endsection
@section('page_classes')claim-page @endsection

@section('content')
<div id="page-content" class="profile2">
  <div class="bg-primary clearfix">
    
  </div>

  <ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
    <li class=""><a href="{{ url(route('patient.myclaims')) }}" data-toggle="tooltip" data-placement="right" title="" data-original-title="Back to My Claims"><i class="fa fa-chevron-left"></i></a></li>
    <li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-ioi" data-target="#tab-ioi" aria-expanded="true"><i class="fa fa-bars"></i> IOI</a></li>
    <li class=""><a role="tab" data-toggle="tab" href="#tab-activity" data-target="#tab-activity" aria-expanded="false"><i class="fa fa-clock-o"></i> Activity</a></li>
    <li class=""><a role="tab" data-toggle="tab" href="#tab-docs" data-target="#tab-docs" aria-expanded="false"><i class="fa fa-file-word-o"></i> Docs</a></li>
    <li class=""><a role="tab" data-toggle="tab" href="#tab-photos" data-target="#tab-photos" aria-expanded="false"><i class="fa fa-file-photo-o"></i> Photos</a></li>
    <li class=""><a role="tab" data-toggle="tab" href="#tab-action" data-target="#tab-action" aria-expanded="false"><i class="fa fa-cube"></i> Action</a></li>
  </ul>

    <div class="tab-content">
      <!-- IOI -->
      <div role="tabpanel" class="tab-pane fade active in" id="tab-ioi">
        <div class="tab-content">
          <div class="panel infolist">
            <div class="panel-default panel-heading">
              <h4>Incident of Injury Information</h4>
            </div>
            <div class="panel-body">
              @include('mic.patient.claim.partials.ioi')
            </div>
          </div>
        </div>
      </div>

      <!-- Activity -->
      <div role="tabpanel" class="tab-pane fade" id="tab-activity">
        <div class="tab-content">
          <div class="panel infolist">
            <div class="panel-default panel-heading">
              <h4>Activity</h4>
            </div>
            <div class="panel-body">
              @include('mic.patient.claim.partials.activity')
            </div>
          </div>
        </div>
      </div>

      <!-- Docs -->
      <div role="tabpanel" class="tab-pane fade" id="tab-docs">
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

      <!-- Photos -->
      <div role="tabpanel" class="tab-pane fade" id="tab-photos">
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

      <!-- Action -->
      <div role="tabpanel" class="tab-pane fade" id="tab-action">
        <div class="tab-content">
          <div class="panel infolist">
            <div class="panel-default panel-heading">
              <h4>Action</h4>
            </div>
            <div class="panel-body">
              @include('mic.patient.claim.partials.action')
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

</div>

@endsection
