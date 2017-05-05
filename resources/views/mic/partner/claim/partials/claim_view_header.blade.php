<div class="claim-view-header content-box white">
  <div class="claim-info row">
    <div class="col-sm-8 section-1">
      <h3 class="text-color-primary"><strong>Cooper Davidson</strong></h3>
      <div class="claim-description">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
      </div>
      <div class="claim-doi">
        <strong>DOI: 3/1/17</strong>
      </div>
    </div>
    <div class="col-sm-4 section-2">
      <ul class="user-info">
        <li>
          <i class="fa fa-calendar-o" aria-hidden="true"></i>
          <span>9 years old (2/15/2004)</span>
        </li>
        <li>
          <i class="fa fa-mobile-phone" aria-hidden="true"></i>
          <span>949-555-5555</span>
        </li>
        <li>
          <i class="fa fa-envelope-o" aria-hidden="true"></i>
          <span>anyemail@email.com</span>
        </li>
        <li>
          <i class="fa fa-map-marker" aria-hidden="true"></i>
          <span>232 Painter Hill Road</span>
        </li>
      </ul>
    </div>
  </div>

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
  </div>
</div>
