<div class="box-body table-responsive">

  <table class="table table-striped table-hover">
    <thead>
      <th class="partner-name">Full Name</th>
      <th class="partner-email">Email</th>
      <th class="partner-role">Membership Role</th>
      <th class="partner-company">Company</th>
      <th class="partner-phone">Phone</th>
      <th class="action">Action</th>
    </thead>
    <tbody>
      @foreach ($partner_list as $user)
      <tr class="partner-item" data-partner-uid="{{ $user->id }}">
        <td class="partner-name">{{ $user->name }}</td>
        <td class="partner-email">{{ $user->email }}</td>
        <td class="partner-role">{{ MICHelper::getPartnerTypeTitle($user->partner) }}</td>
        <td class="partner-company">{{ $user->partner->company }}</td>
        <td class="partner-phone">{{ $user->partner->phone}}</td>
        <td class="action">
          @if (MICHelper::checkIfP2C($user->id, $claim->id))
          <span class="text-green">Assigned</span>
          @else
          <a class="btn btn-primary btn-sm assign-partner-link" href="#tab-partners" 
              data-url="{{ route('micadmin.claim.assign.partner', [$claim->id, $user->id]) }}">
            Assign
          </a>
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

</div><!-- /.box-body -->

@push('scripts')
<script>
(function ($) {
$(document).ready(function() {
  $('a.assign-partner-link').click(function() {
    var assign_url = $(this).data('url');
    var $partner_item = $(this).closest('.partner-item');
    var partner = $partner_item.find('.partner-name').html();
    bootbox.confirm({
      message: "<p>Are you sure to assign "+partner+" to Claim #{{ $claim->id }}?</p>", 
      callback: function (result) {
        if (result) {
          window.location.href = assign_url;
        }
      }
    });
  });
});
}(jQuery));
</script>

@endpush
