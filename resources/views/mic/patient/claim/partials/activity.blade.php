<div class="activity-list-section box">
  @include('mic.patient.claim.partials.activity_list')
</div>

@push('scripts')
<script>
$(function () {
  // $('li.tab-activity a').on('click', function() {
  //   var load_url = '{{ route('claim.activity_list', [$claim->id]) }}';
  //   loadClaimActivity(load_url);
  // });
});

function loadClaimActivity(load_url) {
  $.ajax({
      dataType: 'json',
      url: load_url,
      success: function ( json ) {
        $(".activity-list-section").empty();
        $(".activity-list-section").html(json.activity_html);
      }
  });
}
</script>
@endpush
