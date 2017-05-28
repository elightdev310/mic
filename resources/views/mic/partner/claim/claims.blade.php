@extends('mic.layouts.partner')

@section('htmlheader_title')My Claims @endsection

@section('page_id')my_claims @endsection

@section('page_classes')my-claims @endsection

@section('content')
  
  {{-- Assigned Claims awaiting approval--}}
  @if (isset($assign_requests) && $assign_requests->count() > 0)
  <div class="row">
    <section class="col-md-12">
      <div class="my-assign-request-list box box-success">
        <div class="box-header row">
          <div class="col-sm-12">
            <h4>Assigned Claims awaiting approval</h4>
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

  <div class="my-claims-list">
    <div class="row">
        @foreach ($claims as $claim)
        <div class="col-sm-6 col-md-4" data-claim-id="{{ $claim->id }}">
          <div class="claim-item-box content-box text-center">
            <a href="{{ route('claim.view', [$claim->id]) }}"><h3 class="text-bold text-color-primary">{{ $claim->patientUser->name }}</h3></a>
            <div class="claim-description text-left">
              Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            </div>
            <div class="claim-submit-date text-bold">
              <strong>DOI: {{ MICUILayoutHelper::strTime($claim->created_at, 'n/j/y') }}</strong>
            </div>
          </div>
        </div>
        @endforeach

    </div>
  </div><!-- /.my-claims-list -->

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
