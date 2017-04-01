@if (session('_panel')=='partners')
  @include('mic.admin.partials.success_error')
@endif

@if (isset($assign_requests) && $assign_requests->count() > 0 )
<div class="box box-success">
  <div class="box-header">
    <h4>Assign Requests</h4>
  </div>
  <div class="box-body table-responsive">
    <table class="table table-striped table-hover">
      <thead>
        <th class="partner-name">Partner</th>
        <th class="partner-role">Membership Role</th>
        <th class="submitted-at">Submit Time</th>
        <th class="partner-approve text-center">Partner Approved</th>
        <th class="row-action">Action</th>
      </thead>
      <tbody>
        @foreach ($assign_requests as $req)
        <tr class="request-item" data-partner-uid="{{ $req->id }}">
          <td class="partner-name">{{ $req->partnerUser->name }}</td>
          <td class="partner-role">{{ MICHelper::getPartnerTypeTitle($req->partnerUser->partner) }}</td>
          <td class="submitted-at">{{ MICUILayoutHelper::strTime($req->created_at, "M d, Y H:i") }}</td>
          <td class="partner-approve text-center">{{ ucfirst(config('mic.car_status.'.$req->partner_approve)) }}</td>
          <td class="row-action">
            <a href="#" class="btn btn-primary btn-sm car-approve-link car-link" 
                data-url="{{route('patient.claim.assign-request.action', [$req->claim_id, $req->id, 'approve'])}}">
              Approve
            </a>&nbsp;&nbsp;
            <a href="#" class="btn btn-warning btn-sm car-reject-link car-link" 
                data-url="{{route('patient.claim.assign-request.action', [$req->claim_id, $req->id, 'reject'])}}">
              Reject
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div><!-- /.box-body -->
</div>
@endif

<div class="box box-primary mt30">
  <div class="box-header">
    <h4>Assigned Partners</h4>
  </div>
  <div class="box-body table-responsive">
    <table class="table table-striped table-hover">
      <thead>
        <th class="partner-name">Full Name</th>
        <th class="partner-email">Email</th>
        <th class="partner-role">Membership Role</th>
        <th class="partner-company">Company</th>
        <th class="partner-phone">Phone</th>

      </thead>
      <tbody>
        @foreach ($partners as $user)
        <tr class="partner-item" data-partner-uid="{{ $user->id }}">
          <td class="partner-name">
            {!! MICUILayoutHelper::avatarImage($user, 24) !!}
            {{ $user->name }}
          </td>
          <td class="partner-email">{{ $user->email }}</td>
          <td class="partner-role">{{ MICHelper::getPartnerTypeTitle($user->partner) }}</td>
          <td class="partner-company">{{ $user->partner->company }}</td>
          <td class="partner-phone">{{ $user->partner->phone}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div><!-- /.box-body -->
</div>

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
