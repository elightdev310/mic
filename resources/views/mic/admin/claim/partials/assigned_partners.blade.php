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
      @foreach ($partners as $user)
      <tr class="partner-item" data-partner-uid="{{ $user->id }}">
        <td class="partner-name">{{ $user->name }}</td>
        <td class="partner-email">{{ $user->email }}</td>
        <td class="partner-role">{{ MICHelper::getPartnerTypeTitle($user->partner) }}</td>
        <td class="partner-company">{{ $user->partner->company }}</td>
        <td class="partner-phone">{{ $user->partner->phone}}</td>
        <td class="action">
          <a class="btn btn-warning btn-sm unassign-partner-link" href="#tab-partners" 
              data-url="{{ route('micadmin.claim.unassign.partner', [$claim->id, $user->id]) }}">
            Unassign
          </a>
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
  $('a.unassign-partner-link').click(function() {
    var assign_url = $(this).data('url');
    var $partner_item = $(this).closest('.partner-item');
    var partner = $partner_item.find('.partner-name').html();
    bootbox.confirm({
      message: "<p>Are you sure to unassign "+partner+" from Claim #{{ $claim->id }}?</p>", 
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

