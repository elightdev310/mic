<div class="claim-info row">
  <div class="col-sm-8 section-1">
    <h2 class="text-color-primary"><strong>{{ $claim->patientUser->name }}</strong></h2>
    <div class="claim-description">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
    </div>
    <div class="claim-doi">
      <strong>DOI: {{ MICUILayoutHelper::strTime($claim->created_at, 'n/j/y') }}</strong>
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
        <span>{{ $claim->patientUser->patient->phone }}</span>
      </li>
      <li>
        <i class="fa fa-envelope-o" aria-hidden="true"></i>
        <span>{{ $claim->patientUser->email }}</span>
      </li>
      <li>
        <i class="fa fa-map-marker" aria-hidden="true"></i>
        <span>232 Painter Hill Road</span>
      </li>
    </ul>
  </div>
</div>
