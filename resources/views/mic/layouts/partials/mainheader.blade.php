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
        <a href="{{ url(config('mic.front_url')) }}" class="logo">
          <img class="site-logo" typeof="foaf:Image" src="{{ config('mic.logo_url') }}" alt="{{ LAConfigs::getByKey('sitename') }}">
        </a>
        <div class="logo-slogan hidden-xs">Medical Injury Care Provider Network</div>
    </div>

    <div class="collapse navbar-collapse">
      <div class="top-navbar navbar-right">
        @if (isset($currentUser))
        <div class="clearfix">
        <ul class="nav navbar-nav user-nav">
          <li class="dropdown notifications-menu">
            <!-- Menu toggle button -->
            <a href="#" class="user-notify-link dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="msg-count @if (MICNotification::getUnreadCount($currentUser->id)==0) hidden @endif">
                {{ MICNotification::getUnreadCount($currentUser->id) }}
              </span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-noti-list">
                <!-- Inner Menu: contains the notifications -->
                
              </li>
              <li class="footer"><a href="{{ route('notification.list') }}">View all</a></li>
            </ul>
          </li>

          <li class="dropdown">
            <a href="#" class="dropdown-toggle user-nav-link" data-toggle="dropdown">
                <strong>{{ $currentUser->name }}</strong>
                <div class="caret">&nbsp;</div>
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
              <li class="user-menu-item"><a href="{{ route('user.settings') }}" class="clearfix"><span class="pull-left">Edit Profile</span> <span class="glyphicon glyphicon-user pull-right"></span></a></li>
              <li class="user-menu-item"><a href="{{ route('user.settings') }}?panel=AccountSettings" class="clearfix"><span class="pull-left">Change Password</span> <span class="glyphicon glyphicon-cog pull-right"></span></a></li>
              @if ($currentUser->type == 'patient' || $currentUser->type == 'partner')
              <li class="user-menu-item"><a href="{{ route('user.settings') }}?panel=PaymentSettings" class="clearfix"><span class="pull-left">Payment Information</span> <span class="glyphicon glyphicon-credit-card pull-right"></span></a></li>
              @endif
              <li class="user-menu-item"><a href="{{ url('/logout') }}" class="clearfix"><span class="pull-left">Log Out</span> <span class="glyphicon glyphicon-log-out pull-right"></span></a></li>
            </ul>
          </li>
        </ul>
        </div>
        @endif

        @include('mic.layouts.partials.top_menu')
        
       </div>
    </div>

  </div>
</div>

</header>

@push('scripts')
<script>
$(function () {
  $('.user-nav').on('click', 'a.user-notify-link', function() {
    var load_url = '{{ route('notification.user_notify') }}';
    loadUserNotify(load_url);
  });
});

function loadUserNotify(load_url) {
  $(".user-noti-list").loadingOverlay();
  $.ajax({
      dataType: 'json',
      url: load_url,
      success: function ( json ) {
        $(".user-noti-list").loadingOverlay('remove');
        $(".user-noti-list").empty();
        $(".user-noti-list").html(json.notify_html);
        MICApp.UI.refreshUserNotifyCount(json.count);
      }
  });
}

</script>
@endpush
