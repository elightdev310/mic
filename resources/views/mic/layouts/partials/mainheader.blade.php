<!-- Main Header -->

<header class="main-header">
  <!-- Logo -->
  <div class="container">
    <a href="{{ url(config('mic.front_url')) }}" class="logo">
      <img class="site-logo" typeof="foaf:Image" src="{{ config('mic.logo_url') }}" alt="{{ LAConfigs::getByKey('sitename') }}">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>{{ LAConfigs::getByKey('sitename_short') }}</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>{{ LAConfigs::getByKey('sitename_part1') }}</b>
      {{ LAConfigs::getByKey('sitename_part2') }}</span>
    </a>
  </div>

</header>
