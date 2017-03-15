<div class="box-body table-responsive">

  <table class="table table-striped table-hover">
    <thead>
      <th class="partner-name">Partner</th>
      <th class="partner-role">Membership Role</th>
      <th class="submitted-at">Submit Time</th>
      <th class="partner-approve text-center">Partner Approved</th>
      <th class="patient-approve text-center">Patient Approved</th>
      <th class="status"></th>
    </thead>
    <tbody>
      @foreach ($assign_requests as $req)
      <tr class="request-item" data-partner-uid="{{ $req->id }}">
        <td class="partner-name">
          {!! MICUILayoutHelper::avatarImage($req->partnerUser, 24) !!}
          {{ $req->partnerUser->name }}
        </td>
        <td class="partner-role">{{ MICHelper::getPartnerTypeTitle($req->partnerUser->partner) }}</td>
        <td class="submitted-at">{{ MICUILayoutHelper::strTime($req->created_at, "M d, Y H:i") }}</td>
        <td class="partner-approve text-center">{{ ucfirst(config('mic.car_status.'.$req->partner_approve)) }}</td>
        <td class="patient-approve text-center">{{ ucfirst(config('mic.car_status.'.$req->patient_approve)) }}</td>
        <td class="status">{{ ucfirst($req->status) }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

</div><!-- /.box-body -->

@push('scripts')
<script>
(function ($) {

});
}(jQuery));
</script>

@endpush
