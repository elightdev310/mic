<!-- Main Header -->

<header class="main-header">
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container"> 
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span> 
        </button>
        <a href="{{ url(config('mic.front_url')) }}" class="logo navbar-brand">
          <img class="site-logo" typeof="foaf:Image" src="{{ config('mic.logo_url') }}" alt="{{ LAConfigs::getByKey('sitename') }}">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>{{ LAConfigs::getByKey('sitename_short') }}</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>{{ LAConfigs::getByKey('sitename_part1') }}</b>
          {{ LAConfigs::getByKey('sitename_part2') }}</span>
        </a>
    </div>

    @if (isset($currentUser))
    <div class="collapse navbar-collapse">
      {{-- <ul class="nav navbar-nav">
          <li><a href="#">Home</a></li>
          <li class="active"><a href="#" target="_blank">About</a></li>
           <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">DropDown
              <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                  <li><a href="#">Link 2</a></li>
              </ul>
           </li>              
       </ul> --}}
      <ul class="nav navbar-nav user-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle user-nav-link" data-toggle="dropdown">
              {!! MICUILayoutHelper::avatarImage($currentUser, 40) !!}
              <strong>{{ $currentUser->name }}</strong>
          </a>
          <ul class="dropdown-menu">
            <li>
                <div class="navbar-login">
                    <div class="row">
                        <div class="col-lg-4">
                            <p class="text-center">
                              {!! MICUILayoutHelper::avatarImage($currentUser, 80) !!}
                            </p>
                        </div>
                        <div class="col-lg-8">
                            <p class="text-left"><strong>{{ $currentUser->name }}</strong></p>
                            <p class="text-left small">{{ $currentUser->email }}</p>
                            
                        </div>
                    </div>
                </div>
            </li>
            <li class="user-menu-item"><a href="{{ route('user.settings') }}">Edit Profile <span class="glyphicon glyphicon-user pull-right"></span></a></li>
            <li class="user-menu-item"><a href="{{ route('user.settings') }}?panel=AccountSettings">Change Password <span class="glyphicon glyphicon-cog pull-right"></span></a></li>
            @if ($currentUser->type == 'partner')
            <li class="user-menu-item"><a href="{{ route('user.settings') }}?panel=PaymentSettings">Payment Information <span class="glyphicon glyphicon-credit-card pull-right"></span></a></li>
            @endif
            <li class="user-menu-item"><a href="{{ url('/logout') }}">Log Out <span class="glyphicon glyphicon-log-out pull-right"></span></a></li>
          </ul>
        </li>
      </ul>
    </div>
    @endif

  </div>
</div>

</header>