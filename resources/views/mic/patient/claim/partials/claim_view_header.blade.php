<div class="claim-view-header content-box white">
  @include('mic.patient.claim.partials.claim_view_info')

  <div class="claim-tabs clearfix">
    <a href="{{ route('claim.view.activity', [$claim->id]) }}" class="claim-activity">
      <span>Activity Feed</span>
    </a>
    <a href="{{ route('claim.view.docs', [$claim->id]) }}" class="claim-docs">
      <span>Docs</span>
    </a>
    <a href="{{ route('claim.view.photos', [$claim->id]) }}" class="claim-photos">
      <span> Photos</span>
    </a>
    <a href="{{ route('claim.view.action', [$claim->id]) }}" class="claim-others">
      <span>Actions</span>
    </a>
    <a href="{{ route('claim.view.partners', [$claim->id]) }}" class="">
      <span>Partners</span>
    </a>
  </div>
</div>
