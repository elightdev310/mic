@extends('mic.layouts.partner')

@section('htmlheader_title')My Claims @endsection
@section('contentheader_title')My Claims @endsection

@section('page_id')my_claims @endsection

@section('page_classes')my-claims @endsection

@section('content')
  @include('mic.admin.partials.success_error')
  <div class="row">
    <section class="col-md-12">
      <div class="my-claims-list box box-primary">
        <div class="box-header row">
          <div class="col-sm-6">

          </div>
          <div class="col-sm-6 text-right">
            
          </div>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <th class="claim-id">#</th>
            <th class="patient-name">Patient Name</th>
            <th class="claim-submit-date">Created At</th>
            <th class="row-action">Action</th>
          </thead>
          <tbody>
            @foreach ($claims as $claim)
            <tr data-claim-id="{{ $claim->id }}">
              <td class="claim-id">
                <a href="{{ route('partner.claim.page', [$claim->id]) }}" class="">
                  Claim #{{ $claim->id }}
                </a>
              </td>
              <td>{{ $claim->patientUser->name }}</td>
              <td class="claim-submit-date">{{ MICUILayoutHelper::strTime($claim->created_at, "M d, Y H:i") }}</td>
              <td class="row-action">
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>

        </div><!-- /.box-body -->
        <div class="box-footer clearfix no-border">
          <div class="paginator pull-right">
            
          </div>
        </div>

      </div><!-- /.box -->

    </section>
  </div>


  @if (isset($assign_requests) && $assign_requests->count() > 0)
  <div class="row">
    <section class="col-md-12">
      <div class="my-assign-request-list box box-success">
        <div class="box-header row">
          <div class="col-sm-12">
            <h4>Assign Requests</h4>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <th class="claim-id">#</th>
            <th class="patient-name">Patient Name</th>
            <th class="submitted-at">Submit Time</th>
            <th class="row-action">Action</th>
          </thead>
          <tbody>
            @foreach ($assign_requests as $req)
            <tr class="request-item" data-partner-uid="{{ $req->id }}">
              <td class="claim-id">claim #{{ $req->claim_id }}</td>
              <td class="patient-name">{{ $req->claim->patientUser->name }}</td>
              <td class="submitted-at">{{ MICUILayoutHelper::strTime($req->created_at, "M d, Y H:i") }}</td>
              <td class="row-action">
                <a href="#" class="btn btn-primary btn-sm car-approve-link car-link" 
                    data-url="{{route('partner.claim.assign-request.action', [$req->claim_id, $req->id, 'approve'])}}">
                  Approve
                </a>&nbsp;&nbsp;
                <a href="#" class="btn btn-warning btn-sm car-reject-link car-link" 
                    data-url="{{route('partner.claim.assign-request.action', [$req->claim_id, $req->id, 'reject'])}}">
                  Reject
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>

        </div><!-- /.box-body -->
        <div class="box-footer clearfix no-border">
          <div class="paginator pull-right">
            
          </div>
        </div>

      </div><!-- /.box -->

    </section>
  </div>
  @endif

@endsection

@push('scripts')
<script>
(function ($) {
$(document).ready(function() {
  $('a.car-approve-link').click(function() {
    var action_url = $(this).data('url');
    bootbox.confirm({
      message: "<p>Are you sure to approve this request?</p>", 
      callback: function (result) {
        if (result) {
          window.location.href = action_url;
        }
      }
    });
  });
  $('a.car-reject-link').click(function() {
    var action_url = $(this).data('url');
    bootbox.confirm({
      message: "<p>Are you sure to reject this request?</p>", 
      callback: function (result) {
        if (result) {
          window.location.href = action_url;
        }
      }
    });
  });

});
}(jQuery));
</script>
@endpush
